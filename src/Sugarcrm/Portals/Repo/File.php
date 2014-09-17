<?php namespace Sugarcrm\Portals\Repo;

use Illuminate\Database\Eloquent\Model,
    App;

class File extends Model
{

    protected $filemanager;

    protected $fillable = array(
        'user_id',
        'title',
        'description',
        'keywords',
        'filename',
        'extension',
        'type',
        'size',
        'permissions',
        'user_id'
    );

    public function groups()
    {
        return $this->hasMany('Sugarcrm\Portals\Repo\Group');
    }

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->filemanager = App::make('flysystem');
    }

    public function fmWriteStream($input_file)
    {
        // Upload file
        $stream = fopen($input_file->getPathname(), 'r+');
        $this->filemanager->writeStream(
            $input_file->getClientOriginalName(),
            $stream,
            array(
                'visibility' => 'private',
                'mimetype'   => $input_file->getMimeType(),
            )
        );

        return $this;
    }

    public function fmReadStream($file)
    {
        // Retrieve a read-stream
        $tmpfname = tempnam("/tmp", $file->filename);
        $stream   = $this->filemanager->readStream($file->filename);
        $contents = stream_get_contents($stream);
        $handle   = fopen($tmpfname, "w");
        fwrite($handle, $contents);
        fclose($handle);

        return $tmpfname;
    }

}