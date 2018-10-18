<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ImageUploadValidator extends Controller
{

    public function validateImageUpload(Request $request, $fieldname)
    {
        if (is_array($request->$fieldname)) {

            $imageRules = array(
                'file' => 'image');

            foreach($request->$fieldname as $image) {
                $image = array('file' => $image);

                $imageValidator = Validator::make($image,$imageRules);

                if ($imageValidator->fails()) {

                    $this->throwValidationException(
                        $request, $imageValidator
                    );

                }
            }

        } else {

            $validator = $this->ImageValidator($request->all(), $fieldname);

            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }

            return true;
        }
    }


    public function ImageValidator(array $data, $fieldname)
    {
        return Validator::make($data, [
            $fieldname => 'image'
        ]);
    }
}