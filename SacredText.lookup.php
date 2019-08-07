<?php

class SacredTextLookup {
 
	public static function parseInput( $input, &$book, &$chapternum, &$versenums,
		&$secondChapterNum = '', &$secondVerseNum = '' ) {
		if( preg_match( "/^\s*([\s\w]*\w+)\s*(\d+):(\d+)/", $input, $matches) ) {
	        $book = $matches[1];
	        $chapternum = $matches[2];
	        $versenums = array();
	        $versenums[] = $matches[3];
		// Hack to fix problem with regex putting, e.g. "Revelation 2 0:15"
		// instead of "Revelation 20:15"
		while ( is_numeric ( $book[ strlen ( $book ) - 1] ) ) {
			// Add a number to the beginning of $chapter
			$chapternum = substr ( $book , strlen ( $book ) - 1 ) . $chapternum;
			// Chop one character off the end of $book
			$book = substr ( $book, 0, strlen ( $book ) - 1 );
		}
		$book = trim ( $book );
		// Get the second verse, e.g. verse 14 in 1 Peter 2:13-14
		$secondChapterNum = $chapternum;
		$secondVerseNum = $versenums[0];
		$dashExploded = explode ( '-', $input );
		if ( count ( $dashExploded ) === 2 ) {
			$colonExploded = explode ( ':', $dashExploded[ 1 ] );
			if ( count ( $colonExploded ) > 2
				|| ! is_numeric ( $colonExploded[ 0 ] )
				|| ( isset ( $colonExploded[ 1 ] )
					&& ! is_numeric ( $colonExploded[ 1 ] ) )
				) {
				return true;
			}
			if ( count ( $colonExploded ) === 2 ) {
				$secondChapterNum = $colonExploded [ 0 ];
				$secondVerseNum = $colonExploded [ 1 ];
			} else {
				$secondVerseNum = $colonExploded [ 0 ];
			}
			// Bail if, e.g., 1 Peter 2:14-13 is put
			if ( $secondChapterNum < $chapternum
				|| ( $secondChapterNum == $chapternum
					&& $secondVerseNum < $versenums[0] ) ) {
				$secondChapterNum = $chapternum;
				$secondVerseNum = $versenums[0];
			}
		}
	        return true;
	    } else {
	        return false;
	    }
	}
 
	public static function hookBible( $input, $args, $parser, $frame ) {
		if( self::parseInput( $input, $book, $chapternum, $versenums,
			$secondChapterNum, $secondVerseNum ) ) {
			$lang = "en";
			$ver = "kjv";
			if( array_key_exists("lang", $args) ) $lang = $args["lang"];
			if( array_key_exists("ver", $args) ) $ver = $args["ver"];
			return htmlspecialchars( $input ) ." ". self::lookup( "Christian Bible",
				$book,$chapternum, $versenums, $lang, $ver, $secondChapterNum,
				$secondVerseNum );
		} else {
		        return htmlspecialchars( $input .
				" Could not parse reference.  Please use the format 'Gen 1:10'." );
		}
	}
 
	public static function hookSacredText( $input, $args, $parser, $frame ) {
		if( self::parseInput( $input, $book, $chapternum, $versenums,
			$secondChapterNum, $secondVerseNum ) ) {
	        $lang = "en";
	        $ver = "kjv";
	        $religtext = "Christian Bible";
	        if( array_key_exists("lang", $args) ) $lang = $args["lang"];
	        if( array_key_exists("ver", $args) ) $ver = $args["ver"];
	        if( array_key_exists("text", $args) ) $religtext = $args["text"];
 
	        return htmlspecialchars( $input ) ." ". self::lookup( $religtext, $book,
			$chapternum, $versenums, $lang, $ver, $secondChapterNum, $secondVerseNum );
	    } else {
	        return htmlspecialchars( $input . " Could not parse reference. '
			. 'Please use the format 'Gen 1:10'." );
	    }
	}
 
	public static function parserFunctionHookSacredText ( $parser, $param1 = '' ) {
		return self::hookSacredText ( $param1, array(), $parser, array() );
	}
 
	public static function parserFunctionHookBible ( $parser, $param1 = '' ) {
		return self::hookBible ( $param1, array(), $parser, array() );
	}
 
	public static function lookup( $religtext, $book, $chapternum, $versenums, $lang, $ver,
		$secondChapterNum, $secondVerseNum ) {
	    global $wgSacredChapterAlias, $wgDBPrefix;
	    $dbr = wfGetDB( DB_REPLICA );
 
	    if( array_key_exists($religtext, $wgSacredChapterAlias) &&
	        array_key_exists($book, $wgSacredChapterAlias[$religtext] ) )
	    {
	        $book = $wgSacredChapterAlias[$religtext][$book];
	    }
 
	    if( strcasecmp($religtext,"Christian Bible")==0 ) {
	        if( strcasecmp($ver,"AV")==0 ) {
	            $ver = "KJV";
	        }
	    }
 
	    if ( $chapternum == $secondChapterNum ) {
		$where = array ( "{$wgDBPrefix}st_chapter_num=$chapternum
			AND {$wgDBPrefix}st_verse_num>=$versenums[0]
			AND {$wgDBPrefix}st_verse_num<=$secondVerseNum" );
	    } else {
		$whereClause = "(({$wgDBPrefix}st_chapter_num=$chapternum
			AND {$wgDBPrefix}st_verse_num>=$versenums[0])
			OR  ({$wgDBPrefix}st_chapter_num=$secondChapterNum
			AND {$wgDBPrefix}st_verse_num<=$secondVerseNum)";
		$chapterArray = range ( $chapternum, $secondChapterNum );
		foreach ( $chapterArray as $thisChapter ) {
			if ( $thisChapter != $chapternum && $thisChapter != $secondChapterNum ) {
				$whereClause .= " OR {$wgDBPrefix}st_chapter_num=$thisChapter";
			}
		}
		$whereClause .= ')';
		$where = array ( $whereClause );
	    }
	    $where = array_merge ( $where, array(
	            "st_religious_text" => $religtext,
	            "st_book"           => $book,
	            "st_translation"    =>$ver,
	            "st_language"       =>$lang
	        ) );
	    $obj = $dbr->select( "sacredtext_verses", array("st_text"), $where );
	    if( $obj ) {
		$returnText = '';
		$keepGoing = true;
		$firstOne = true;
		while ( $keepGoing === true ) {
			$row = $obj->fetchRow();
			if ( $row ) {
				if ( $firstOne !== true ) {
					$returnText .= ' ';
				}
				$firstOne = false;
				$returnText .= $row['st_text'];
			} else {
				$keepGoing = false;
			}
		}
	        return htmlspecialchars( $returnText );
	    } else {
			#$r = self::fallback( $religtext, $book, $chapternum, $versenums, $lang, $ver );
			#if( $r ) return htmlspecialchars( $r );
			
        	return htmlspecialchars( "Could not find: ". $book ." ".$chapternum.":".$versenums[0]
			." in the ". $religtext );
    	}
	}
 
	public static function fallback( $religtext, $book, $chapternum, $versenums, $lang, $ver ) 
	{
		global $wgSacredFallbackServers;
		if ( !$wgSacredFallbackServers ) {
			$wgSacredFallbackServers = array();
		}
	    if( array_key_exists($religtext, $wgSacredFallbackServers) ) {
	    	if( array_key_exists($lang, $wgSacredFallbackServers[$religtext]) ) {
	    		if( array_key_exists($ver, $wgSacredFallbackServers[$religtext][$lang]) ) {
					$url = $wgSacredFallbackServers[$religtext][$lang][$ver]["url"];
					$regex = $wgSacredFallbackServers[$religtext][$lang][$ver]["pattern"];
				}
			}
		}
		if( strcmp($religtext,"Christian Bible")==0 )
		{
			$versenum = $versenums[0];
			$h = fopen("http://www.biblegateway.com/passage/?search=$book%20$chapternum:$versenum&version=$ver",'r' );
			$str='';
			$length = 8192;
			while(!feof($h)) $str.=fread($h,$length);
			fclose($h);
			$num = preg_match_all( '/<\/sup>\s*([^<]+)\s*/',$str, $matches, PREG_PATTERN_ORDER );
			if( $num ) {
				return implode( " ", $matches[1] );
			}
			else return false;
		} 
		return false;
	}
}
