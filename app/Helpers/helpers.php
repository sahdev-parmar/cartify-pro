<?php
    if (!function_exists('product_images')) {
        function product_images($images, $separator = ',')
        {
            if (empty($images)) {
                return null;
            }

            $imagesArray = explode($separator, $images);

            return $imagesArray ?? null;
        }
    }

?>