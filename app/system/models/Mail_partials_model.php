<?php

namespace System\Models;

use Exception;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Mail\MailParser;
use Igniter\Flame\Support\Facades\File;
use Illuminate\Support\Facades\View;
use System\Classes\MailManager;

/**
 * MailPartials Model Class
 */
class Mail_partials_model extends Model
{
    protected static $codeCache;

    /**
     * @var string The database table name
     */
    protected $table = 'mail_partials';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'partial_id';

    protected $guarded = [];

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = true;

    protected $casts = [
        'is_custom' => 'boolean',
    ];

    //
    // Events
    //
    protected function afterFetch()
    {
        if (!$this->is_custom) {
            $this->fillFromCode();
        }
    }

    //
    // Helpers
    //

    public function fillFromCode($code = null)
    {
        if (is_null($code))
            $code = $this->code;

        $definitions = MailManager::instance()->listRegisteredPartials();
        if (!$definition = array_get($definitions, $code))
            throw new ApplicationException('Unable to find a registered partial with code: '.$code);

        $this->fillFromView($definition);
    }

    public function fillFromView($path)
    {
        $sections = self::getTemplateSections($path);
        $this->name = array_get($sections, 'settings.name', '???');
        $this->html = array_get($sections, 'html');
        $this->text = array_get($sections, 'text');
    }

    public static function findOrMakePartial($code)
    {
        try {
            if (!$template = self::whereCode($code)->first()) {
                $template = new self;
                $template->code = $code;
                $template->fillFromCode();
            }

            return $template;
        }
        catch (Exception $ex) {
            return null;
        }
    }

    /**
     * Loops over each mail layout and ensures the system has a layout,
     * if the layout does not exist, it will create one.
     * @return void
     */
    public static function createPartials()
    {
        $dbPartials = self::lists('code', 'code')->all();
        $definitions = MailManager::instance()->listRegisteredPartials();
        foreach ($definitions as $code => $path) {
            if (array_key_exists($code, $dbPartials)) {
                continue;
            }

            $partial = new static;
            $partial->code = $code;
            $partial->is_custom = 0;
            $partial->fillFromView($path);
            $partial->save();
        }
    }

    protected static function getTemplateSections($code)
    {
        return MailParser::parse(File::get(View::make($code)->getPath()));
    }
}
