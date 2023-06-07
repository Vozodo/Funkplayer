<?php



class Functions
{
	


	public static function GetSongImage(Song $Song)
	{
		$CoverImg = false;

		switch (MD_IMAGE_PROVIDER) {
			case 'itunes':
				/* 
				Artwork sizes available from iTunes (as of 10 November 2014)
				30x30, 40x40, 60x60, 80x80, 100x100, 110x110, 130x130, 150x150, 160x160, 170x170, 190x190
				200x200, 220x220, 230x230, 240x240, 250x250, 340x340, 400x400, 440x440, 450x450, 460x460
				480x480, 600x600, 1200x1200, 1400x1400 
				*/

				$term = urlencode($Song->getSongArtist() . " - " . $Song->getSongName()); // user input 'term' in a form
				$json =  file_get_contents('http://itunes.apple.com/search?term=' . $term . '&limit=1&media=music&entity=song');
				$array = json_decode($json, true);

				foreach ($array['results'] as $result) {
					$cover = str_replace('100x100', '340x340', $result['artworkUrl100']); //change 100x100 to 340x340
				}

				if (!empty($cover)) {
					$CoverImg = $cover;
				}

				break;
			case 'musicbrainz':
				$mbidquery = 'http://www.musicbrainz.org/ws/2/recording/?query=artist:' . rawurlencode($Song->getSongArtist()) . '+recording:' . rawurlencode($Song->getSongName()) . '&fmt=json';

				$context  = stream_context_create(array('http' => array('header' => 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.110 Safari/537.36')));
				$mbidJSON = json_decode(file_get_contents($mbidquery, false, $context));

				$mbid = $mbidJSON->recordings[0]->releases[0]->id;

				$imagequery = 'http://coverartarchive.org/release/' . $mbid;

				$CoverImg = json_decode(file_get_contents($imagequery))->images[0]->image;

				break;
		}

		if (!$CoverImg && IM_EN) {
			$CoverImages = glob("model/cover_img/" . str_replace(" ", "_", strtoupper($Song->getSongArtist())) . ".{jpg,png,gif}", GLOB_BRACE);

			$CoverImg = reset($CoverImages);
		}

		if (!$CoverImg && IM_EX_EN) {
			$query = IM_EX_URL . "?artist=" . $Song->getSongArtist();
			$ch = curl_init($query);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if (200==$retcode) {
				if (!file_get_contents($query)) {
					$CoverImg = false;
				} else {
					$CoverImg = $query;
				}
			} else {
				$CoverImg = false;
			}


		}


		return (!$CoverImg || $CoverImg === NULL) ? StationLogo : $CoverImg;

	}


	public static function WriteLog($log_msg)
	{
		$log_filename = "log";
		if (!file_exists($log_filename)) {

			// create directory/folder uploads.
			mkdir($log_filename, 0777, true);
		}
		$log_file_data = $log_filename . '/log_' . date('d-M-Y') . '.log';
		file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
	}
}
