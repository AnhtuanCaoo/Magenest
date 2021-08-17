<?php


namespace Magenest\Customer\Model\CustomerData\Avatar;

class Image
{
    /**
     * Check the image file
     * @param $tmp_name, $attrCode
     * @return bool
     */
    public function isImageValid($tmp_name, $attrCode)
    {
        if ($attrCode == 'avatar') {
            if (!empty($_FILES[$attrCode][$tmp_name])) {
                $imageFile = @getimagesize($_FILES[$attrCode][$tmp_name]);
                if ($imageFile === false) {
                    return false;
                } else {
                    $valid_types = ['image/gif', 'image/jpeg', 'image/png'];
                    if (!in_array($imageFile['mime'], $valid_types)) {
                        return false;
                    }
                }
                return true;
            }
        }
        return true;
    }
}
