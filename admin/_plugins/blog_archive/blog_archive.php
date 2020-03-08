<?php

    $tags = array_keys($xml);
    $first_tag = "_";
    while(count($tags) > 0 && substr($first_tag, 0, 1) == "_") {
        $first_tag = array_shift($tags);
    }
    

    //echo "FIRST_TAG: $first_tag\n";

    if(isset($xml[$first_tag][0]["_blog_archive_max"])) {
        $archive_edit = readXml($xml, "$first_tag _blog_archive_edit");
        $archive_file = $root."/".array_pop(explode(":", $archive_edit));
        $archive_folder = readXml($xml, "$first_tag _blog_archive_media");
        $blog_max = readXml($xml, "$first_tag _blog_archive_max");
        $updated_flag = false;
        
        //echo "max: $blog_max\nfolder: $archive_folder\nfile: $archive_file\n\n";
        
        $archive_xml = loadXml($archive_file);
        //arrayList($archive_xml);

        // ====== Check for content to archive ======
        $blog_tag = false;
        foreach(array_keys($xml) as $tag) {
            
            if(count($xml[$tag]) > $blog_max) {
                $blog_posts = $xml[$tag];
                $archive_posts = [];
                $archive_media = [];
                $n = 1;
                foreach(array_keys($blog_posts) as $post_num) {
                    if($post_num >= $blog_max) {
                        $post = $blog_posts[$post_num];


                        // Move to post to archive xml array
                        $archive_posts[] = $post;
                        unset($blog_posts[$post_num]);

                    }
                };
                
                if(count($blog_posts) < count($xml[$tag])) {
                    $archive_posts = array_merge($archive_posts, $archive_xml[$tag]);
                    $archive_xml[$tag] = array_values($archive_posts);
                    $xml[$tag] = $blog_posts;
                    $updated_flag = true;
                    
                    //arrayList($xml);
                };
            }
            
            
            // ====== Check for content to get back ======
            if(count($xml[$tag]) < $blog_max && count($archive_xml[$tag]) > 0) {
                //while
            }
            
        };
        
        
        // ====== Save archive & move files ======
        if($updated_flag) {
            $xml_declaration = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
            
            //echo "#save to: $archive_file\n";
            //echo "#save to: $path\n";
            
            if(safeSave($archive_file, "$xml_declaration\n<xable>\n".arrayToXml($archive_xml, 1)."</xable>\n") &&
               safeSave($path, "$xml_declaration\n<xable>\n".arrayToXml($xml, 1)."</xable>\n"))
            {

                echo "<script>\n";
                echo "\talert(\"Blog archive: Done!\")\n";
                echo "\tlocation.reload();\n";
                echo "</script>\n";
                
            }
            

            
        };

    };

                


?>