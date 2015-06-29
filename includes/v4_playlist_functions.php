<?php
/*
* @author: Marienne Lopez
* @filename: playlist_functions.php
* @desc: functions that have anything to do with loading and unloading a playlist.
* @sources: m3u.class.php provided by Robert Widdick and writing to m3u file by https://github.com/ChoiZ/php-playlist-generator/blob/master/generate.php
*/

class m3uParser {
  /*
  * Private Variables
  */
  private $m3uFile;
  private $m3uFile_SongLengths;
  private $m3uFile_SongTitles;
  private $m3uFile_SongLocations;

  /**
  * @desc Load the M3u file and initiate it for parsing
  */
  public function __construct($m3uFile) {
    /**
    * @desc Load the file into an array
    **/
    if(file_exists($m3uFile))
      $this -> m3uFile = file($m3uFile);
    else
      die("Unable to locate '$m3uFile'");

    /**
    * @desc "Loosely" check that the file is an m3u file
    **/
    if(strtoupper(trim($this -> m3uFile[0])) != "#EXTM3U")
      die("The file specified {$this -> m3uFileLocation} is not a valid M3U playlist.");

    /**
    * @desc Remove extra empty lines
    */
    $buffer = array();
    foreach($this -> m3uFile as $line) {
      if($line != "\n" || $line != "\r" || $line != "\r\n" || $line != "\n\r")
        $buffer[] = $line;
    }
    $this -> m3uFile = $buffer;

    /**
    * @desc Shift the first line "#EXTM3U" off the array
    **/
    array_shift($this -> m3uFile);

    /**
    * @desc Start parsing the m3u file
    */
    $this -> _init();
  }

  /**
  * @desc Hopefully free some memory (though not yet proven to work as thought)
  */
  public function __destruct() {
    unset($this->m3uFile);
  }

  /**
  * @desc Initiate each array storing the Song Lengths, Titles and Locations
  */
  private function _init() {
    foreach($this -> m3uFile as $key => $line) {
      if(strtoupper(substr($line, 0, 8)) == "#EXTINF:") {
        $line = substr_replace($line, "", 0, 8);
        $line = explode(",", $line, 2);

        $this -> m3uFile_SongLengths[]   = $line[0];
        $this -> m3uFile_SongTitles[]    = $line[1];
        $this -> m3uFile_SongLocations[] = $this -> m3uFile[$key + 1];
      }
    }
  }

  /**
  * @desc Single case[in]sensitive searching
  * @return array Returns indexes of songs indicated in the playlist.
  */
  public function searchTitles($search, $caseSensitive = false) {
    $results = array();

      #foreach($this -> m3uFile_SongTitles as $songTitle) {
      for($i=0; $i<count($this->m3uFile_SongTitles); $i++){
        $_search = stristr($this->m3uFile_SongTitles[$i], $search); #: stristr($this->m3uFile_SongTitles[$i], $search);

        if($_search)
          $results[] = $i;
      }
      sort($results, SORT_NUMERIC);

    return $results;

  }

  /**
  * @desc Single case[in]sensitive searching
  * @return array Returns indexes of songs indicated in the playlist.
  */
  public function searchLocations($search, $ignoreDirectorySeperator = true, $caseSensitive = false) {
    $results = array();

      #foreach($this -> m3uFile_SongLocations as $songLocation) {
      for($i=0; $i<count($this->m3uFile_SongLocations); $i++){
        if($ignoreDirectorySeperator)
          $_search = stristr(str_replace(array("/", "\\"), "", $this->m3uFile_SongLocations[$i]), $search); #: stristr(str_replace(array("/", "\\"), "", $this->m3uFile_SongLocations[i]), $search);
        else
          $_search = stristr($this->m3uFile_SongLocations[$i], $search); #: stristr($this->m3uFile_SongLocations[$i], $search);

        if($_search)
          $results[] = $i;
      }
      sort($results, SORT_NUMERIC);

    return $results;
  }

  /**
  * @desc Search song lengths by equal length, less than length, less than or equal to length, greater than length, greater than or equal to length or in between [start, end].
  * @return array Returns array of song indexes.
  */
  public function searchLengths($type, $start, $end = null) {
    $results = array();

    #foreach($this -> m3uFile_SongLengths as $key => $length) {
    for($i=0; $i<count($this->m3uFile_SongLengths); $i++){
      switch($type) {
        // Find lengths that equal to $start
        case 0: {
            if($this->m3uFile_SongLengths[$i] == $start)
              $results[] = $i;
        } break;

        // Find lengths that are less than $start
        case 1: {
            if($start < $this->m3uFile_SongLengths[$i])
              $results[] = $i;
        } break;

        // Find lengths that are less than or equal to $start
        case 2: {
            if($start <= $this->m3uFile_SongLengths[$i])
              $results[] = $i;
        } break;

        // Find lengths that are longer than $start
        case 3: {
            if($start > $this->m3uFile_SongLengths[$i])
              $results[] = $i;
        } break;

        // Find lengths that are longer or equal to $start
        case 4: {
            if($start >= $this->m3uFile_SongLengths[$i])
              $results[] = $i;
        } break;

        // Find lengths between $start and $end
        case 5: {
            if($this->m3uFile_SongLengths[$i] >= $start && $this->m3uFile_SongLengths[$i] <= $end)
              $results[] = $i;
        } break;
      }
    }

    sort($results, SORT_NUMERIC);
    return $results;
  }

  /**
  * @desc Prints each array (Song Lengths, Song Titles, Song Locations)
  */
  public function debug() {
    echo "<pre>";
    #MLDL's edit on debug() function, displays per song information listed in the m3u:
    for ($i = 0; $i < count($this -> m3uFile_SongLocations); $i++){
      echo $this -> m3uFile_SongLengths[$i] . "<br>";
      echo $this -> m3uFile_SongLocations[$i]. "<br>";
      echo $this -> m3uFile_SongTitles[$i]. "<br>";
    }
    echo "</pre>";
  }


}
?>