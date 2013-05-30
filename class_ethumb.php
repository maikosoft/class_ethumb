<?php
// class Easy Thumb 		//
// By Miguel A. Martinez	//
// @maikosoft on Twitter	//
$thumb = new Thumb();
$image = $_GET['image'];
$size  = $_GET['size'];
$thumb->createThumb($image,$size);

class Thumb {
    private $defaultSize = 100;
	

	// type of image example: "jpg","png" or "gif"
	public function setType($image)
	{
		$ext = explode(".",$image);
		$num = count($ext)-1;
		$type = $ext[$num];
		$this->type = $type;

	}

	// get the size of source image
	public function getSize($image)
	{
		switch($this->type) {
			case 'jpg':
				$this->source = @imagecreatefromjpeg($image);
				break;
			case 'png':
				$this->source = @imagecreatefrompng($image);
				break;
			case 'gif':
				$this->source = @imagecreatefromgif($image);
				break;
			default:
				die("Invalid file type");
		}
		$this->imgWidth   = imagesx($this->source);
		$this->imgHeight  = imagesy($this->source);
	}

	public function createThumb($image,$size)
	{
		if(file_exists($image) === TRUE) 
		{	
			// set the type of image
			$this->setType($image);
			// get the original size
			$this->getSize($image);

			// if $size exist
			if(!$size) 
			{
				$width  = $this->defaultSize;
				$height = ($this->defaultSize * $this->imgHeight) / $this->imgWidth;
			}
			else // if not, let set defaultSize
			{
				$width  = $size;
				$height = ($size * $this->imgHeight) / $this->imgWidth;
			}

			// create a image from a true color
			$img = imagecreatetruecolor($width,$height);

			//thumb creation
			ImageCopyResized($img,$this->source,0,0,0,0,$width,$height,$this->imgWidth,$this->imgHeight);

			// let's print the thumb
			switch($this->type) {
			case 'jpg':
				Header("Content-type: image/jpeg");
				imageJpeg($img);
				break;
			case 'png':
				Header("Content-type: image/png");
				imagePng($img);
				break;
			case 'gif':
				Header("Content-type: image/gif");
				imageGif($img);
				break;
			}
		}
		else
		{
			die("File doesn't exist");
		}
	}
}
?> 