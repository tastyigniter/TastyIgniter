<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Attach;

use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\MediaUploadValidator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use League\Glide\Server;
use League\Glide\ServerFactory;
use LogicException;

class Manipulator
{
    protected Collection $manipulations;

    protected string $driver = 'gd';

    protected ?Filesystem $source = null;

    protected ?string $tempFilePath = null;

    public function __construct(protected string $file = '')
    {
        $this->manipulations = new Collection;
    }

    public static function make(string $file): self
    {
        return resolve(static::class)->useFile($file);
    }

    public function useFile(string $file): self
    {
        $this->file = $file;
        $this->manipulations = new Collection;

        return $this;
    }

    public function useDriver(string $driver): self
    {
        if (!in_array($driver, ['gd', 'imagick'], true)) {
            throw new LogicException(sprintf("Driver must be 'gd' or 'imagick'. '%s' provided.", $driver));
        }

        $this->driver = $driver;

        return $this;
    }

    public function useSource(Filesystem $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function manipulations(): Collection
    {
        return $this->manipulations;
    }

    public function manipulate(array $manipulations): self
    {
        $this->mergeManipulations($manipulations);

        $glideServer = $this->createGlideServer(
            $this->file, $this->extractWatermarkDirectory($manipulations),
        );

        $glideServer->setGroupCacheInFolders(false);

        $tempImage = $glideServer->makeImage(
            $this->convertToRelativeFilePath($this->file),
            $this->prepareManipulations(),
        );

        $this->tempFilePath = temp_path().DIRECTORY_SEPARATOR.$tempImage;

        return $this;
    }

    public function save(string $path): void
    {
        if ($this->tempFilePath) {
            $this->writeManipulatedContentsTo($path);
            unlink($this->tempFilePath);

            return;
        }

        $this->copyFileContentsTo($path);
    }

    public function isSupported(): bool
    {
        $gdExtensions = [
            'png', 'jpg', 'jpeg', 'gif', 'webp',
        ];

        $imagickExtensions = array_merge($gdExtensions, [
            'tiff', 'bmp', 'ico', 'psd',
        ]);

        if (empty($extension = pathinfo($this->file, PATHINFO_EXTENSION))) {
            return false;
        }

        if ($this->driver === 'gd') {
            return in_array($extension, $gdExtensions, true);
        }

        return in_array($extension, $imagickExtensions);
    }

    protected function mergeManipulations(array $manipulations)
    {
        $manipulations = $this->manipulations()->merge($manipulations);

        $this->manipulations = $manipulations;
    }

    protected function prepareManipulations(): array
    {
        $glideParameters = [];
        $parameters = $this->getAvailableGlideParameters();
        foreach ($this->manipulations() as $name => $argument) {
            if (!$paramName = array_get($parameters, $name)) {
                throw new InvalidArgumentException(sprintf("Unknown parameter '%s' provided when manipulating '%s'", $name, $this->file));
            }

            $glideParameters[$paramName] = $argument;
        }

        return $glideParameters;
    }

    protected function createGlideServer(string $image, ?string $watermarks = null): Server
    {
        $config = [
            'source' => $this->source->getDriver(),
            'cache' => temp_path(),
            'driver' => $this->driver,
        ];

        if (!empty($watermarks)) {
            $config['watermarks'] = $watermarks;
        }

        return ServerFactory::create($config);
    }

    protected function extractWatermarkDirectory(array $manipulations): ?string
    {
        if (array_key_exists('watermark', $manipulations)) {
            return dirname((string)$manipulations['watermark']);
        }

        return null;
    }

    protected function getAvailableGlideParameters(): array
    {
        return [
            'width' => 'w',
            'height' => 'h',
            'blur' => 'blur',
            'pixelate' => 'pixel',
            'crop' => 'fit',
            'manualCrop' => 'crop',
            'orientation' => 'or',
            'flip' => 'flip',
            'fit' => 'fit',
            'devicePixelRatio' => 'dpr',
            'brightness' => 'bri',
            'contrast' => 'con',
            'gamma' => 'gam',
            'sharpen' => 'sharp',
            'filter' => 'filt',
            'background' => 'bg',
            'border' => 'border',
            'quality' => 'q',
            'format' => 'fm',
            'watermark' => 'mark',
            'watermarkWidth' => 'markw',
            'watermarkHeight' => 'markh',
            'watermarkFit' => 'markfit',
            'watermarkPaddingX' => 'markx',
            'watermarkPaddingY' => 'marky',
            'watermarkPosition' => 'markpos',
            'watermarkOpacity' => 'markalpha',
        ];
    }

    public static function decodedBlankImage(): string
    {
        return base64_decode(self::encodedBlankImage());
    }

    public static function encodedBlankImage(): string
    {
        return 'iVBORw0KGgoAAAANSUhEUgAAAZAAAAEsCAIAAABi1XKVAAAACXBIWXMAAABIAAAASABGyWs+AAAACXZwQWcAAAGQAAABLACWMKFnAAAWd0lEQVR42u3d61riShqGYc7/nJa9RlnQKkuZtjdgQEAWG5Wm9QzmvfymazJsYiUh++f94aU20JBQt18VlarWtiL59evX09PTjx8/vr9H36zX69fX1y0hJE47enx8/PbtmxqRvo5Go58/f+qXVXn+rQppNRgM7EDbsZZZ+mWFjjUhhbej+XzuGpG1o/F4XKGX0KrEUbbaKnygMYuQxLVVOF+/flWdBVjZaoVZhKTXqnJmtUp+lCO0wixC0mtVLbNaZT7KH2qFWYSk16pCZrVKe5Q9tcIsQtJrVRWzWuU8yrG0wixC0mtVCbNaJTzKCbTCLELSa7VjVgnbUatsR3m9XifTCrMISa+Va0c2pxSwvMD6niKYRdAqjVbWiIIgAKyP8/r6mrhLiFkErdJrZV3Ccl6yU59Bd8wiaFVvrba1mdaAWQStaq/Vth4TRzGLoFUTtNrW4NIczCJo1RCttlW/+BmzCFo1R6ttpZeXwSyCVo3SalutBfwwi5Ama1UZsDCLELSqEliYRUjDtaoYWJhFSJO1qh5YmEXQqrFaVRIszCJo1UytqgoWZhG0aqBWFQYLswhaNU2raoOFWQStGqVV5cHCLIJWzdGqDmBhFkGrhmhVE7Awi6BVE7SqD1iYRdCq9lrVCizMImhVb63qBhZmEbSqsVY1BAuzCFrVVat6goVZBK3q+qZt1fj0YxZBK8DCLELQCrAwi6AVWjUZLMwiaAVYmEUIWgEWZhG0QivAwiyCVoCFWYSgFWBhFkErtAIszCJoBViYRQhaARZmEbRCK8DCLIJWgIVZhKAVYGEWQavGB7Awi6AVYGEWQSu0AizMImgFWASzCFoBFmYRtEIrwMIsglaARTCLoBVgYRZBK7QCLMwiaAVYBLMIWgEWZhG0QivAwiyCVoBFMIugFWBhFkEr3gaAhVkErQCLYBZaoRVgYRZBKwJYmEXQCrAIZqEVWgEWZhG0IoCFWQStAItgFlqhFWBhFkErAliYRdAKsAhmoRVaARZmEbQigIVZBK0Ai2AWWqEVYGEWQSvA4hBgFqcJrQCLYBZaEcDCLIJWgEUwC63QCrAIZqEVASzMImgFWASz0AqtAItgFloRwMIsglaARTALrdAKsAhmoRUBLMwiaAVYBLPQCq0Ai2RilpoWRxWtAIsUYNYP7+jGg8Hg+fn59fX1V+OjgzCfz2MdwPCRdFoFQYBWgEUOmLVer63ByB0rmtRg7t7zb7/0+/0vX76ooYqtdYOjlz8ej3U0/h0nOnR2tO3Phr7qQezUULQCFtnN29vbarVSM7u8vOx0OhcXF/96z59x8unTJ91FzS9cKTQqeuHX19c6Dn/Gjx3w8/NzHfxer6cepSpfnRrVa7w/AYv8r7xSUTCZTIbDoaxRyzk7O/szaZpsVhqtXHTw2+22ylsrte7v71W00jEELPLf6C+5jZjY2Ln6JnELK8w6lVa6+19//WUnwn2goVOjvyWLxQKzAKvR0d/t8Xis9rDT8GSNxEnT9ppmVkZahT+HVabTKW9awGpu9rXCrEK0skN9TKvw54bquVNnAVYTx63UEzyoFWYVMm71oVbOrPl8jlmA1bhRdp+miFmZauXu2O12Xb/P5//V6cMswGoQWNPp1KdtYFamWrXb7dvbW5vL/vLyoprX5xDpxD08PAAWYDUlm83GZod6NkvMykKrTqcjeiaTif0J2b7Pt1qtVp5PgCILsJpSXi2Xy1jXuGFWFqPsd3d30io8i13fy6zZbPbh2fn69avKMSaUAlYjwFKTiBhux6ystbIPBNWt27/mxnN4UaKpI8mbGbAaEb3XE6wigFmnqq3++OOPm5ubY2dHivkcHN1GXXvezIBV86g9DIfDZMuelNMs+3Dt6+98+52d35Rndmi73dbfjIMjUPrly8uL55FZr9cMYwFWzfuD+rOcRooymGUYmUGDwSAIAnWv1M99fHycz+f//M7je6bTqf71/v7e/q/wfQucy66nrROxw42NYemZ+zw93Ua3ZBgLsGoO1tPTU/pCoxCzrFDS7VWeiKflcvn8/GzDQLYE1cHYAlXb989G9doXi4UIk1/u8slCrryxzwfdc7Po2aq8kmU+z0pPXgcBsACr5mCpH3GSzlFuZllNpG/klGoKNWlr2zut3fPl2x31vbBT/aXqzBp/IVc1q/Szl2NPSafGv7fuyONdDVh1BivunIYCzbKSStWQZLFpR46bkxwKK0/EhGouq2sOrrma3VXNrmC0TmussTa3wh8BLMAq2Cxruip/1IOzkZ3sSgmr1NRhnM/nKnDC1VbWazCEX2zck8LMBsBqBFgi4FRgndwsK3Pc8k+ur5RPxKJwtOtj9Bz0tdfrZa1Vms9GBTpvacCqc9QmTwvWac3q9/syazabWVVVlOkvLy/qJKq2SrPyaqZaARZgNQUsz0/N8zdLOnQ6HT29t7e3Ag+Rm1twc3NzcXGR5mrB7LQysO7v73lLAxZgFWCW7qWKxiYoFTsf0q0UZpMPut1ugleUtVaABViAVYxZ1hm8vb11EzsL3Ed6f/dTG8kqm1aABViAVYBZutn5+fmXL192PiIsxKxjezWr6JOn4fX2CtcKsAALsPI2y66qs87XfmvM2azoneX1ZPr9/ocvKjetAAuwACtXs3xmJ+VmVrRW7kWpElQ9eOxF5akVYAEWYOVnltVWH7btfMzy0Sps1sFNG3PWCrAAC7ByMsvGrQ72BPM3y1+rcN+wcK0AC7AAKyez9OPOKHtKs9xSDfs3cJcfHlt8KpZW4TF494oK0QqwAAuw8jBLX90MhliN05nllhU2hvSjfq8XNZvNHh4eRqNR8Dv6fjKZiKTFYuEWRXByJdNq5xrDorQCLMACrMzNOjs7UztPvGif7rher61iklPL5VIeDYfD8LJ8+3GLXql5T6dTPYKOw9vb23w+j7uw/c6LElU+I3GABVikSmBZN6rf79vGVmmaqB5ntVrpJbjLpGOtx2K3V+Wlpu45iBbxaLKywJXpAQuwACvD1iViHDTJKhp9VYF2cXEh+xJLoTteXV2p1rNNTH+8J9mFx7b0RZoyDbAAi5QUrNlspo6YemR2jV6CTqWIsWGjxOvBh9e3sofqdrt3d3exHkpC2V7NNhyWbAsiwAIsUlKwrPfkFl9/enqKZZYpE74yJplZB1fj27mSMZZW9jX9GvmABVikXGCp6xT+eC6WWQfXS4hrVvTaobZWxIcPtVNbuZcznU4LKVoBC7AAK4925WmW/rXT6UQo42mWz0rH+tfLy8uIhzqo1TbmToKABVik7GCFy6tYZkVo5W+W/7rsus3V1dXBhzqmVbjIynn0HbAAC7AyaVRuqqe/Wfql58p50WbF3UVCt+z1ejsPFa2VvZDn52dmugMWqTZYauqPj48Rq7MfNCuBMgfNSrbnjW4fnjbxoVbuhTw8PBTe1yaABVip5ri/vLx82NTDZtkMhvR7hSXeoSt8bbanVttT758GWIBF8gbLdvr0WWVhxyybb5XGrJT7CdoAvJ5JEAQ+Wll0S/99mwELsEjpwFosFp67dQmF9Xo9GAxSQmNLQaTcT9Aue9RLiHVscx56ByzAAqy8+4Ph8kTPbbVapdlZy3HzZ7rY+oJ28U0ssPT8qbAAi1QPrAQbqavB67n5LJ2eadyKMXoVAiiWWZvNRkUiYAEWqRhY6hnNZrNYuzfbGNBJ9mQ9yV7NegmeY3Dh5HZpIWABFmCdsjktl0v/1h7uTxVl1v5qfLF6tXZ4xXQ+w1iABViAdco8Pz/HAmsymbimnr9ZB9cO1Y86XP51Yp6TGwALsADr9MszxOoP7kwfzc2sYysd+8/McGCJacawAItUDKxYI+7HFmnJx6zoddkHg0FcedmXELBIxcBS/y7W0M+xZ5W1WT67SMTaZExgyZF8RgkBC7AAq4CPCKPHqrMzy0erWNNfLfl8UAhYgAVYJwNrPp/HGquOvnI4C7M8d+j68PrtuK8FsACLlK5LGOvDNZ+qxJmVp1YJqsWdjzsBC7BIBcCK240KguDDZyVcvnz5cpIrb6SVf7UYazwutysKAQuwAKswsHwGqgVWr9c7SYV1fn4u+3w+zgMsAlh0CWNXWClXjEm8HrzoEUCARQALsHzHsE6rVSyzGMMigFVzsE77yVoWWvmbdfJPPAELsEjpwDrVPKzstPI0K+5V3FvmYQEWqVyXUFVGrJnui8Xi4N45mWrlaVasq7g9P0AALMAiJQIrCAL/Z3XwmuF8tIo2K8FV3JvNhmsJAYtUCawE1wzvFCZ5ahVhVoI5DQev4gYswCKlBivBelhuNkD+Wh0zK+6EsmN9W8ACLFJqsOI2dds1x66VKUSrfbP0ZFQnqosXq2+b28Y5gAVYgHXKDwpjzbe0jEajq6urlFqlv7vtFaZXEas/aPG5xgiwAIuUrsKK25ze3t50l7Ozs/TXCZ6fn6dhy5kVa0F33VK3z2fEHbAAC7CKHMbSzebzueqyNPsSuqua7RrpxI9jG6leXl7GGobLcwALsAALsApbFUsoPD4+6vYqT25vb5NBE95PMP36WVZhDQYD/+VGc5vjDliABViFzcYyrcITGjqdTlxoDu7Qldgs3eX6+lpa2QN6mpXnLqqABViAlUmiW/uOVgbN3d1drEWvjq3Gl8ysndWyPM3K/8ACFmABViafFR7rFe5r5aDx7xhGrx2awCzdWGLu7E7oY1Zuez4DFmABVoZT3g9OZTqmVayZ7j4rHcc1q9/v7z9atFk2iex7vgEswAKsnIbeo7Vy0FxeXkbMcvBfl93TLP3rzc1NxLINx8zKebgdsAALsDJsVzvXD/to5aA5No/UXyt/syK0ijArz+sHAQuwACuPIktCqWGLLX+tHDS9Xu/TexJrFW2WTRO9vb31ebR9swoprwALsAArw6iRv7y86H+PpZW7b7/ft8nrxk0CrfbNsg8i1eXUo+2MsvubpaxWq/yPJ2ABFmBl/nGh/utkFwYLCN3RhrTa7XYyrdxD2Tx4PZS+Xl9f2y/jYuHMyme5PsACLMDKtcISDR8OEkU/gn0TBIEJmLid27U74s/msqcZmxuPx98LCmABFmBlpVWv11NFc3Fxkfi/llA2b956YZLCVoDxfEDdTI9gK8ZMJhP1T5+fn20ue+IXZb1Ln73CAAuwSDXACs+o0tdut5ugecua0WjkPmq0wSOhM5/PJZdVSUbSfuzFqhqSU4vFYrPZ/Pod9elMvWReqHPqv78hYAEWKTtY+/M/9b2qrVgdMafVzgQo/aiXYx8+ip7lcim/ZrPZ9Hf0vX6j36uYsrvvTwdLZpbu8vnzZ/chQCFmARZgAVa2Wrl4ziGI0GonVjG9vscVUOEfI+4Y16yDCudvFmABFmDloZXFc5t4H61SJpZZutnff/+9/7ryNwuwAAuwctLKLekZveVyDlrFMks92Zubm2OvK2ezAAuwACsPrVzzPj8/P2ZWnlp5mqV/klYp92QFLMAiJQIr1p431rz7/f7OGHz+Wn1o1rGeYIFmARZgAVZ+Wh0bg9dzK0SrCLPivq58zAIswAKsArSyFn51dWVMBEFQlFb7ZtnXbrebYMnmrM0CLMACrAK0ci283W4Ph0OjKu4291mYpSej7mriXXyyNguwAAuwitHKgaWHWiwW0TOn8gFLGY/H4XUdymYWYAEWYBWmlduhS18lhW0ImD9bbsUYWaAnk3KvsEzN8tyUiABWtcE64Wafp9UqPO6ur9Pp1DZezoctd3WhrcZ3qv0NszMLsACr/lGbXC6XJwErI63Ckxv0y8lkkmm15S4wXK/XtlbMzsEprVlWivKWBizAKl6rMFv6qpappx1eaOEkTtmSD+ojj0ajfapKbpaerYrBYgf7AItkDlb6Daly0yrcOG0pK/UTJZeUse6toePf43O3V9WmrrEavOeiWiU0yxZxBSzAqjlYaqvV0mqnldq9VBPNZjOh8/T05PY9/HUo2/dJEjJOUuv2auQ2oO6/+F85zbKtPY5tUksAqyZgqXmnWae4QK0OriBqz0oGiTD1HFU02WJYk8lE3+s3QRAMh0P7v8L3SrPKaBnM0qtQsUmFBVg1j8oNNeAEjbY8Wh3rM1rCa426nHAaR3nMso8jeEsDVs2LLNUdCdbYLK1WOacMZu1vT0sAq56xzQFj7TqDVmUzS6dPfV7KK8BqRIUV64NCtCqhWQxgARbDWGhVDbPoDwJW44osn14hWpXTLJ24+XxOeQVYDcpms4neRhStymmWLdJAeQVYjSuyIq6CRqvSmqV/ZTYDYDXUrNlstt8xRKtymmV/XVarFVoBVqPNCk+tRKtymqW/K8PhcL1eoxVgNd0s/dFWY7BSC60KN0txG6DZxH098mQyscUqeMcCFmb9+vnz53K5VGMzcc7Ozj6F4t/SdMfw2qFNA8uYTmZW+IDrMNrm2EEQqARm0AqwyP/FLZ18d3d3e3t7dXX1+fNn0XPxHv3B/9dH0W3Uxjqdzvf3HZJ/NDgqV3UYfQ5aOHao2+12t9vV8e/1enoQ9QHf3t54fwIW+b8Ky03LsiZn4uxfVxwRta77+3t1W1Ss2dfGxpa7scsJdq7B/jDhU2DfM24FWGRXqzTdNxtqGY1G9mgcUle02v6GdojS9DH1OBxYwCIn0MqKCNv9lOMZjm0Hu7+PNGYBFilSqwJ3lq/EQcYswCJohVkEsNAKrTCLABZacdgxC7AIWmEWASy0QivMIoCFVpwIzAIsglaYRQALrdAKswhgoRWnBrMAi6AVZhHAQiuCWYBF0IqThVmAhVZohVkEsNCKYBZgEbTi9GEWYKEVWmEWASy0IpgFWAStOKGYBVhohVaYRQALrQhmARZBK04xZgEWWqEVZhHAQiuCWYBF0IqTjlmAhVa8cTGLABZaEcwCLLRCK94GmAVYaEUwiwAWWhHMAiy0QiveGJgFWGhFMIsAFloRzAIstEIr3iqYBVhoRTCLABZaEcwCLLRCK948mAVYaEUwiwAWWhHMAiy04k3G2wmzAAutCGYBFlqhFcEswEIrwhsMswALrQhmARZaoRXBLMBCK4JZmAVYaEUwC7DQCq0IZgEWWhHMwizAQiuCWYCFVmhFMAuw0IpgFmYBFloRzAIstEIrglmAhVYEszCr6WChFcEswEIrQjALsNCKYBZmNQ0stCKYVWOzWjU72WhFMKvGZrXqdJrRimBWvc1q1eYEoxXBrNqb1arHqUUrgllNMKtVg5OKVgSzGmJWq+qnE60IZjXHrFalTyRaEcxqlFmt6p5CtCKY1TSzWhU9eWhFMKuBZrWqeNrQimBWM81qVe6EoRXBrMaa1arWqUIrQppsVqtCJwmtCGm4Wa2qnB60IgSzWpU4MWhFCGZVACy0IgSzqgEWWhGCWdUAC60IwaxqgIVWhGBWNcBCK0IKN+v19RWwvA76fD5HK0Kos8oOlg7QcrkUN2hFSFFm2X0Hg8FmswGsDyJoHh4eEh9rtCLkJHXWYrGgS+h1rPVVZiWos9CKkPRm6S7SijGseIlrFloRkt6sMmu1LfnEUX+z0IqQ9GaVXKtt+S/N8TELrQhJb1b5tdpW4uLnaLPQipD0ZlVCq21Vlpc5ZhZaEZLerKpota3QAn77ZunHIAjQipA0ZlVIq221lkgOz8/SN9RWhKQ3q0JabSu3CcV4PP72HmorQhJENq3Xa5llWv3zzz8V0kr5DyttsWTey3iBAAAAJXRFWHRjcmVhdGUtZGF0ZQAyMDEyLTExLTA2VDEyOjQ4OjEyLTA1OjAwMuk6owAAACV0RVh0bW9kaWZ5LWRhdGUAMjAxMi0xMS0wNlQxMjo0ODoxMi0wNTowMG1YTJcAAAAZdEVYdFNvZnR3YXJlAEFkb2JlIEltYWdlUmVhZHlxyWU8AAAAAElFTkSuQmCC';
    }

    public static function encodedBlankImageUrl(): string
    {
        return 'data:image/png;base64,'.self::encodedBlankImage();
    }

    protected function convertToRelativeFilePath(string $path): string
    {
        $base = $this->source->path('/');

        if (!starts_with($path, $base) && starts_with($path, base_path())) {
            throw new InvalidArgumentException(sprintf('The provided path (%s) must be a relative path to the file, from the source root', $path));
        }

        return starts_with($path, $base) ? substr($path, strlen($base)) : $path;
    }

    protected function writeManipulatedContentsTo(string $path): void
    {
        if (starts_with($path, base_path())) {
            File::copy($this->tempFilePath, $path);
        } else {
            $this->source->put($path, File::get($this->tempFilePath));
        }
    }

    protected function copyFileContentsTo(string $path): void
    {
        $extension = strtolower(pathinfo($this->file, PATHINFO_EXTENSION));

        if ($extension === 'svg' && $this->source) {
            $contents = $this->source->get($this->file);
            $contents = resolve(MediaUploadValidator::class)->validateAndSanitize(basename($this->file), $contents);

            if (starts_with($path, base_path())) {
                File::put($path, $contents);
            } else {
                $this->source->put($path, $contents);
            }

            return;
        }

        if (starts_with($path, base_path())) {
            File::copy($this->file, $path);
        } else {
            $this->source->copy($this->file, $path);
        }
    }
}
