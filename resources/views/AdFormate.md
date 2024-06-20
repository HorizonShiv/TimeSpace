AdFormate
AdSize
AdColour
AdResolution
AdFileType
AdVersion
AdTechnical


  'advertisement_id' => $request->AdType[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'ad_format' => $request->AdFormate[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'ad_size' => $request->AdSize[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'colour' => $request->AdColour[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'resolution' => $request->AdResolution[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'file_type' => $request->AdFileType[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'technical' => $request->AdTechnical[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'social_spec_1' => $request->AdSocialSpec1[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'social_spec_2' => $request->AdSocialSpec2[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'social_spec_3' => $request->AdSocialSpec3[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'conversion' => $request->AdConversion[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'due_to_publisher' => $request->AdDate[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'version' => $request->AdVersion[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? 1,
                        'publisher_specs' => $request->AdPublisherSpecs[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,