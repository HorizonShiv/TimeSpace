   if (strtolower($AdvertisementType->name) == 'fb feed') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Size WxH</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Social Spec 1</p>
                <p class="text-base font-normal w-32" >Social Spec 2</p>
                <p class="text-base font-normal w-32" >Social Spec 3</p>
                <p class="text-base font-normal w-32" >Conversion</p>
                <p class="text-base font-normal w-32" >Version</p>
                ';


                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="1080x1080">1080x1080</option>
                </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="JPEG">JPEG</option>
                    <option value="PNG">PNG</option>
                </select>';


                $htmlField .= '<input type="text" name="AdSocialSpec1[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdSocialSpec2[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdSocialSpec3[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdConversion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'fb video feed') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Size WxH</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Technical</p>
                <p class="text-base font-normal w-32" >Social Spec 1</p>
                <p class="text-base font-normal w-32" >Social Spec 2</p>
                <p class="text-base font-normal w-32" >Social Spec 3</p>
                <p class="text-base font-normal w-32" >Conversion</p>
                <p class="text-base font-normal w-32" >Version</p>
                ';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                        <option value="4:5">4:5</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="1080x1080">1080x1080</option>
                    <option value="1080x1350">1080x1350</option>
                </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="MP4">MP4</option>
                    <option value="MOV">MOV</option>
                    <option value="GIF">GIF</option>
                </select>';


                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdTechnical[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="1s-241min">1s-241min</option>
                    <option value="4GB">4GB</option>
                </select>';

                $htmlField .= '<input type="text" name="AdSocialSpec1[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdSocialSpec2[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdSocialSpec3[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdConversion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'fb stories') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'fb reels') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';

                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'fb ads on reels') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }
            if (strtolower($AdvertisementType->name) == 'insta profile feed') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }
            if (strtolower($AdvertisementType->name) == 'insta feed') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'insta stories') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }
            if (strtolower($AdvertisementType->name) == 'insta reels') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }
            if (strtolower($AdvertisementType->name) == 'carousel') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }
            if (strtolower($AdvertisementType->name) == 'collection') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }


            if (strtolower($AdvertisementType->name) == 'standard image') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>
                <p class="text-base font-normal w-32" >Ad Size WxH</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Social Spec 1</p>
                <p class="text-base font-normal w-32" >Social Spec 2</p>
                <p class="text-base font-normal w-32" >Social Spec 3</p>
                <p class="text-base font-normal w-32" >Version</p>
                ';


                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="1080x1080">1080x1080</option>
                </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="JPEG">JPEG</option>
                    <option value="PNG">PNG</option>
                </select>';


                $htmlField .= '<input type="text" name="AdSocialSpec1[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdSocialSpec2[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdSocialSpec3[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }