<?php

// This is where all globally defined variables whould be.
// Consider putting any hard-coded variables here.

// DB connection variables
define("DB_SERVER", "localhost");
define("DB_USER", "ucmnuorg_studios");
define("DB_PASSWORD", "NUeecs338");
define("DB_NAME", "ucmnuorg_wikistudios");

// PATH variables.  Add as necessary to abastract the paths (so they can change)
define("ROOT", "/home/ucmnuorg/public_html/wikistudios/");
define("HTDOCS_PATH", ROOT . "htdocs/");
define("INCLUDES_PATH", ROOT . "includes/");
define("ACCESSORS_PATH", ROOT . "accessors/");
define("CLASSES_PATH", ROOT . "classes/");

// Youtube Developer Credentials
define("YoutubeClientID", "AI39si5eRjODFkv8IM3mI3B67n52px4BOK7f9RMFQDvwxPOCb-deybqqDq5J7YPBxUYIywFtHzVoOW3Vb2vXLshhoeUSctidTw");
define("YTClientID", "ytapi-CaryLee-WikiStudios-6red0jpo-0");
define("YoutubeDevKey", "AI39si5eRjODFkv8IM3mI3B67n52px4BOK7f9RMFQDvwxPOCb-deybqqDq5J7YPBxUYIywFtHzVoOW3Vb2vXLshhoeUSctidTw");

// Site name should be used as a variable so we can easily change it
$SiteName = "WikiStudios";
?>