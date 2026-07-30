
# Utility Classes Documentation

## FileWrapper

Wraps file with mime-type and filename to be sent as part of an HTTP request.

## Constructor Args

| Name | Type | Description |
|  --- | --- | --- |
| $realFilePath | string | The path of the file to wrap. |
| $mimeType | ?mimeType | The mime-type to be sent with the file. |
| $filename | ?string | The name to be used when sending the file. |

## Methods

| Name | Type | Description |
|  --- | --- | --- |
| getFilename() | ?string | Get name of the file to be used in the upload data. |
| getMimeType() | ?string | Get the mime-type to be sent with the file. |

