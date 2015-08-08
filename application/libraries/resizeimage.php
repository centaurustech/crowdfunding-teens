<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class resizeImage {
	// *** Class variables
	private $image;
	private $width;
	private $height;

	// *** Add to class variables
	private $imageResized;

	function __construct($params) {

		//Adapt parameter according to CI Standard Libraries
		if (isset($params["fileName"])) {
			$this->loadImage($params["fileName"]);
		}

	}

	private function openImage($file) {
		// *** Get extension
		$extension = strtolower(strrchr($file, '.'));

		switch ($extension) {
			case '.jpg':
			case '.jpeg':
				$img = @imagecreatefromjpeg($file);
				break;
			case '.gif':
				$img = @imagecreatefromgif($file);
				break;
			case '.png':
				$img = @imagecreatefrompng($file);
				break;
			default:
				$img = false;
				break;
		}

		return $img;
	}

	private function getDimensions($newWidth, $newHeight, $option) {

		switch ($option) {
			case 'exact':
				$optimalWidth  = $newWidth;
				$optimalHeight = $newHeight;
				break;
			case 'portrait':
				$optimalWidth  = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight = $newHeight;
				break;
			case 'landscape':
				$optimalWidth  = $newWidth;
				$optimalHeight = $this->getSizeByFixedWidth($newWidth);
				break;
			case 'auto':
			case 'scale':
				$optionArray   = $this->getSizeByAuto($newWidth, $newHeight, $option);
				$optimalWidth  = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];
				break;
			case 'crop':
				$optionArray   = $this->getOptimalCrop($newWidth, $newHeight);
				$optimalWidth  = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];
				break;
		}
		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}

	private function getSizeByFixedHeight($newHeight) {
		$ratio    = $this->width/$this->height;
		$newWidth = $newHeight*$ratio;
		return $newWidth;
	}

	private function getSizeByFixedWidth($newWidth) {
		$ratio     = $this->height/$this->width;
		$newHeight = $newWidth*$ratio;
		return $newHeight;
	}

	private function checkSizeWhenScaling($newMeassure, $currentMeassure) {

		// ** Function used when streching the image on scale mode,
		// ** keeping meassure when the new value is greater than the the original

		if ($currentMeassure <= $newMeassure) {
			return $currentMeassure;
		} else {
			return $newMeassure;
		}

	}

	private function getSizeByAuto($newWidth, $newHeight, $option) {

		if (strtolower($option) == 'scale') {
			$newWidth  = $this->checkSizeWhenScaling($newWidth, $this->width);
			$newHeight = $this->checkSizeWhenScaling($newHeight, $this->height);
		}

		if ($this->height < $this->width)
		// *** Image to be resized is wider (landscape)
		{
			$optimalWidth  = $newWidth;
			$optimalHeight = $this->getSizeByFixedWidth($newWidth);

		} elseif ($this->height > $this->width)
		// *** Image to be resized is taller (portrait)
		{
			$optimalWidth  = $this->getSizeByFixedHeight($newHeight);
			$optimalHeight = $newHeight;
		} else {

			// *** Image to be resized is a square
			{
				if ($newHeight < $newWidth) {
					$optimalWidth  = $newWidth;
					$optimalHeight = $this->getSizeByFixedWidth($newWidth);
				} else if ($newHeight > $newWidth) {
					$optimalWidth  = $this->getSizeByFixedHeight($newHeight);
					$optimalHeight = $newHeight;
				} else {
					// *** Sqaure being resized to a square
					$optimalWidth  = $newWidth;
					$optimalHeight = $newHeight;
				}
			}
		}

		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}

	private function getOptimalCrop($newWidth, $newHeight) {

		$heightRatio = $this->height/$newHeight;
		$widthRatio  = $this->width/$newWidth;

		if ($heightRatio < $widthRatio) {
			$optimalRatio = $heightRatio;
		} else {
			$optimalRatio = $widthRatio;
		}

		$optimalHeight = $this->height/$optimalRatio;
		$optimalWidth  = $this->width/$optimalRatio;

		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}

	private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight) {
		// *** Find center - this will be used for the crop
		$cropStartX = ($optimalWidth/2)-($newWidth/2);
		$cropStartY = ($optimalHeight/2)-($newHeight/2);

		$crop = $this->imageResized;
		//imagedestroy($this->imageResized);

		// *** Now crop from center to exact requested size
		$this->imageResized = imagecreatetruecolor($newWidth, $newHeight);

		//Set Transaprency for PNG files
		if (imagetypes()&IMG_PNG) {
			imagealphablending($this->imageResized, false);
			imagesavealpha($this->imageResized, true);
			$bg = imagecolorallocatealpha($this->imageResized, 255, 255, 255, 127);
			imagefilledrectangle($this->imageResized, 0, 0, $optimalWidth, $optimalHeight, $bg);
		}

		imagecopyresampled($this->imageResized, $crop, 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight, $newWidth, $newHeight);
	}

	private function scale($optimalWidth, $optimalHeight, $newWidth, $newHeight) {
		// *** Find center - this will be used for the crop

		$offsetX = 0;
		$offsetY = 0;

		$offset_fillX = 0;
		$offset_fillY = 0;

		$scaleWidth  = $newWidth;
		$scaleHeight = $newHeight;

		$ratio_applied = false;

		if ($newWidth > $optimalWidth) {
			$offsetX      = ($newWidth-$optimalWidth)/2;
			$offset_fillX = $newWidth-$offsetX-1;
		} else if ($newWidth < $optimalWidth) {
			$scaleWidth = $optimalWidth;
		}

		if ($newHeight > $optimalHeight) {
			$offsetY      = ($newHeight-$optimalHeight)/2;
			$offset_fillY = $newHeight-$offsetY;
		} else if ($newHeight < $optimalHeight) {
			$scaleHeight = $optimalHeight;
		}

		$scale = $this->imageResized;

		// *** Now crop from center to exact requested size
		$this->imageResized = imagecreatetruecolor($newWidth-5, $newHeight);

		//Set Transaprency for PNG files
		if (imagetypes()&IMG_PNG) {

			imagealphablending($this->imageResized, false);
			imagesavealpha($this->imageResized, true);
			//$bg = 0xFF0000;
			$bg = imagecolorallocatealpha($this->imageResized, 255, 255, 255, 127);
			imagefilledrectangle($this->imageResized, 0, 0, $newWidth, $newHeight, $bg);
		}

		imagecopyresampled($this->imageResized, $scale, $offsetX, $offsetY, 0, 0, $newWidth, $newHeight, $scaleWidth, $scaleHeight);

		if ($offset_fillX > 0 && $offset_fillX < $newWidth) {
			//$bg = 0x0000FF;
			imagefilledrectangle($this->imageResized, $offset_fillX, 0, $newWidth, $newHeight, $bg);
		}

		if ($offset_fillY > 0 && $offset_fillY < $newHeight) {
			//$bg = 0x00F0F0;
			imagefilledrectangle($this->imageResized, 0, $offset_fillY, $newWidth, $newHeight, $bg);
		}

		var_dump_pretty(
			array(
				"newHeight" => $newHeight,
			), false

		);

	}

	public function loadImage($fileName) {

		// *** Open up the file
		$this->image = $this->openImage($fileName);

		// *** Get width and height
		$this->width  = imagesx($this->image);
		$this->height = imagesy($this->image);

	}

	public function resize($newWidth, $newHeight, $option = "auto") {

		// *** Get optimal width and height - based on $option

		$optionArray = $this->getDimensions($newWidth, $newHeight, strtolower($option));

		$optimalWidth  = $optionArray['optimalWidth'];
		$optimalHeight = $optionArray['optimalHeight'];

		// *** Resample - create image canvas of x, y size
		$this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);

		imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);

		// *** if option is 'crop', then crop too
		if ($option == 'crop') {
			$this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
		}

		// *** if option is 'scale', then scale too
		if ($option == 'scale') {
			$this->scale($optimalWidth, $optimalHeight, $newWidth, $newHeight);
		}

	}

	public function saveImage($savePath, $imageQuality = "100") {
		// *** Get extension
		$extension = strrchr($savePath, '.');
		$extension = strtolower($extension);

		switch ($extension) {
			case '.jpg':
			case '.jpeg':
				if (imagetypes()&IMG_JPG) {
					imagejpeg($this->imageResized, $savePath, $imageQuality);
				}
				break;

			case '.gif':
				if (imagetypes()&IMG_GIF) {
					imagegif($this->imageResized, $savePath);
				}
				break;

			case '.png':
				// *** Scale quality from 0-100 to 0-9
				$scaleQuality = round(($imageQuality/100)*9);

				// *** Invert quality setting as 0 is best, not 9
				$invertScaleQuality = 9-$scaleQuality;

				if (imagetypes()&IMG_PNG) {
					imagepng($this->imageResized, $savePath, $invertScaleQuality);
				}
				break;

				// ... etc

			default:
				// *** No extension - No save.
				break;
		}

		imagedestroy($this->imageResized);
	}

}