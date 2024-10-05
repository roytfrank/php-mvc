<?php declare (strict_types = 1);

namespace App\Classes;
use App\Classes\UploadFile;
use App\Models\Image;
use Carbon\Carbon;

class validateImages {

	public static function storeImages($image1_path, $image2 = NULL, $image3 = NULL, $image4 = NULL, $tmp_name2 = NULL, $tmp_name3 = NULL, $tmp_name4 = NULL) {
		$ds = DIRECTORY_SEPARATOR;
		if (isset($image2) && $image2 != NULL) {
			UploadFile::move($tmp_name2, "uploads{$ds}products", $image2);
			$image_path2 = UploadFile::path();
		} else {
			$image_path2 = 0;
		}
		if (isset($image3) && $image3 != NULL) {
			UploadFile::move($tmp_name3, "uploads{$ds}products", $image3);
			$image_path3 = UploadFile::path();
		} else {
			$image_path3 = 0;
		}
		if (isset($image4) && $image4 != NULL) {
			UploadFile::move($tmp_name4, "uploads{$ds}products", $image4);
			$image_path4 = UploadFile::path();
		} else {
			$image_path4 = 0;
		}

		$image = Image::create([
			'image1' => $image1_path,
			'image2' => $image_path2,
			'image3' => $image_path3,
			'image4' => $image_path4,
			'created_at' => Carbon::now("America/New_York"),
			'updated_at' => Carbon::now("America/New_York"),
		]);

		if ($image) {
			return true;
		}
	}

	public static function updateImages($image1_path, $image2 = NULL, $image3 = NULL, $image4 = NULL, $tmp_name2 = NULL, $tmp_name3 = NULL, $tmp_name4 = NULL, $obj) {

		$ds = DIRECTORY_SEPARATOR;

		if (isset($image2)) {
			if (UploadFile::move($tmp_name2, "uploads{$ds}products", $image2)) {
				$image_path2 = UploadFile::path();
				unlink('/' . $obj->$image2);
			}
		} else {
			$image_path2 = NULL;
		}

		if (isset($image3)) {
			if (UploadFile::move($tmp_name3, "uploads{$ds}products", $image3)) {
				$image_path3 = UploadFile::path();
				unlink('/' . $obj->$image3);
			}
		} else { $image_path3 = NULL;}

		if (isset($image4)) {
			if (UploadFile::move($tmp_name4, "uploads{$ds}products", $image4)) {
				$image_path4 = UploadFile::path();
				unlink('/' . $obj->$image4);
			}
		} else { $image_path4 = NULL;}

		$image = Image::where('id', $obj->id)->first();

		if ($image) {
			$image->image1 = !empty($image1_path) ? $image1_path : $image->image1;
			$image->image2 = !empty($image_path2) ? $image_path2 : $image->image2;
			$image->image3 = !empty($image_path3) ? $image_path3 : $image->image3;
			$image->image4 = !empty($image_path4) ? $image_path4 : $image->image4;
			$image->updated_at = Carbon::now("America/New_York");
			$image->save();

			return true;
		}
	}

/**
 * required image validation
 * @param $image name
 * @param  $imagesize size
 * @return mix
 */
	public static function requiredImage($image, $imagesize, $name) {
		if (empty($image)) {
			$file_errors[$name] = [$name . " is required"];
			return $file_errors;
		}
		if (!UploadFile::validExtension($image)) {
			$file_errors[$name] = [$name . " is invalid type"];
		}
		if (!UploadFile::checkFilesize($imagesize)) {
			$file_errors[$name] = [$name . " is too large"];
		}
		if (isset($file_errors)) {
			return $file_errors;
		} else {return "completed";}
	}

/**
 * not required image validation
 * @param $image name
 * @param  $imagesize size
 * @return mix
 */
	public static function validImage($image, $imagesize, $name) {
		if (!empty($image)) {

			if (!UploadFile::validExtension($image)) {
				$file_errors[$name] = [$name . " type is invalid"];
			}
			if (!UploadFile::checkFilesize($imagesize)) {
				$file_errors[$name] = [$name . " is too large"];
			}
			if (isset($file_errors)) {
				return $file_errors;
			} else {return "completed";}
		}

		return "completed";
	}
}