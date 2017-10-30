<?php
/**
 * SacredText MediaWiki extension.
 *
 * This extension makes it easy to quote religious scriptures.
 *
 * Written by Jonathan Williford and Leucosticte
 * https://www.mediawiki.org/wiki/User:JonathanWilliford
 * https://www.mediawiki.org/wiki/User:Leucosticte
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Extensions
 */
 
# Alert the user that this is not a valid entry point to
# MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/SacredText/SacredText.php" );
EOT;
	exit( 1 );
}
 
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'SacredText',
	'author' => array( '[https://www.mediawiki.org/wiki/User:JonathanWilliford Jonathan Williford]',
		'[https://www.mediawiki.org/wiki/User:Leucosticte Leucosticte]' ),
	'descriptionmsg' => 'sacredtext-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SacredText',
	'version' => '0.0.3',
);
 
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['SacredTextLookup'] = $dir . 'SacredText.lookup.php';
 
// the following are the parameters that can be set in LocalSettings.php
$wgSacredUseBibleTag = true;
$wgSacredUpdateTable = true; // Drop and create new table when update.php is run
$wgSacredChapterAlias = array();
$wgSacredChapterAlias["Christian Bible"] = array();
$wgSacredChapterAlias["Christian Bible"]["1Chronicles"]="1 Chronicles";
$wgSacredChapterAlias["Christian Bible"]["1Corinthians"]="1 Corinthians";
$wgSacredChapterAlias["Christian Bible"]["1John"]="1 John";
$wgSacredChapterAlias["Christian Bible"]["1Kings"]="1 Kings";
$wgSacredChapterAlias["Christian Bible"]["1Peter"]="1 Peter";
$wgSacredChapterAlias["Christian Bible"]["1Samuel"]="1 Samuel";
$wgSacredChapterAlias["Christian Bible"]["1Thessalonians"]="1 Thessalonians";
$wgSacredChapterAlias["Christian Bible"]["1Timothy"]="1 Timothy";
$wgSacredChapterAlias["Christian Bible"]["2Chronicles"]="2 Chronicles";
$wgSacredChapterAlias["Christian Bible"]["2Corinthians"]="2 Corinthians";
$wgSacredChapterAlias["Christian Bible"]["2John"]="2 John";
$wgSacredChapterAlias["Christian Bible"]["2Kings"]="2 Kings";
$wgSacredChapterAlias["Christian Bible"]["2Peter"]="2 Peter";
$wgSacredChapterAlias["Christian Bible"]["2Samuel"]="2 Samuel";
$wgSacredChapterAlias["Christian Bible"]["2Thessalonians"]="2 Thessalonians";
$wgSacredChapterAlias["Christian Bible"]["2Timothy"]="2 Timothy";
$wgSacredChapterAlias["Christian Bible"]["3John"]="3 John";
$wgSacredChapterAlias["Christian Bible"]["1Ch"]="1 Chronicles";
$wgSacredChapterAlias["Christian Bible"]["1Co"]="1 Corinthians";
$wgSacredChapterAlias["Christian Bible"]["1Jo"]="1 John";
$wgSacredChapterAlias["Christian Bible"]["1Ki"]="1 Kings";
$wgSacredChapterAlias["Christian Bible"]["1Pe"]="1 Peter";
$wgSacredChapterAlias["Christian Bible"]["1Sa"]="1 Samuel";
$wgSacredChapterAlias["Christian Bible"]["1Th"]="1 Thessalonians";
$wgSacredChapterAlias["Christian Bible"]["1Ti"]="1 Timothy";
$wgSacredChapterAlias["Christian Bible"]["2Ch"]="2 Chronicles";
$wgSacredChapterAlias["Christian Bible"]["2Co"]="2 Corinthians";
$wgSacredChapterAlias["Christian Bible"]["2Jo"]="2 John";
$wgSacredChapterAlias["Christian Bible"]["2Ki"]="2 Kings";
$wgSacredChapterAlias["Christian Bible"]["2Pe"]="2 Peter";
$wgSacredChapterAlias["Christian Bible"]["2Sa"]="2 Samuel";
$wgSacredChapterAlias["Christian Bible"]["2Th"]="2 Thessalonians";
$wgSacredChapterAlias["Christian Bible"]["2Ti"]="2 Timothy";
$wgSacredChapterAlias["Christian Bible"]["3Jo"]="3 John";
$wgSacredChapterAlias["Christian Bible"]["Act"]="Acts";
$wgSacredChapterAlias["Christian Bible"]["Amo"]="Amos";
$wgSacredChapterAlias["Christian Bible"]["Col"]="Colossians";
$wgSacredChapterAlias["Christian Bible"]["Dan"]="Daniel";
$wgSacredChapterAlias["Christian Bible"]["Deu"]="Deuteronomy";
$wgSacredChapterAlias["Christian Bible"]["Ecc"]="Ecclesiastes";
$wgSacredChapterAlias["Christian Bible"]["Eph"]="Ephesians";
$wgSacredChapterAlias["Christian Bible"]["Est"]="Esther";
$wgSacredChapterAlias["Christian Bible"]["Exo"]="Exodus";
$wgSacredChapterAlias["Christian Bible"]["Eze"]="Ezekial";
$wgSacredChapterAlias["Christian Bible"]["Ezr"]="Ezra";
$wgSacredChapterAlias["Christian Bible"]["Gal"]="Galatians";
$wgSacredChapterAlias["Christian Bible"]["Gen"]="Genesis";
$wgSacredChapterAlias["Christian Bible"]["Ge"]="Genesis";
$wgSacredChapterAlias["Christian Bible"]["Hab"]="Habakkuk";
$wgSacredChapterAlias["Christian Bible"]["Hag"]="Haggai";
$wgSacredChapterAlias["Christian Bible"]["Heb"]="Hebrews";
$wgSacredChapterAlias["Christian Bible"]["Hos"]="Hosea";
$wgSacredChapterAlias["Christian Bible"]["Isa"]="Isaiah";
$wgSacredChapterAlias["Christian Bible"]["Jam"]="James";
$wgSacredChapterAlias["Christian Bible"]["Jer"]="Jeremiah";
$wgSacredChapterAlias["Christian Bible"]["Job"]="Job";
$wgSacredChapterAlias["Christian Bible"]["Joe"]="Joel";
$wgSacredChapterAlias["Christian Bible"]["Joh"]="John";
$wgSacredChapterAlias["Christian Bible"]["Jon"]="Jonah";
$wgSacredChapterAlias["Christian Bible"]["Jos"]="Joshua";
$wgSacredChapterAlias["Christian Bible"]["Jud"]="Jude";
$wgSacredChapterAlias["Christian Bible"]["Jud"]="Judges";
$wgSacredChapterAlias["Christian Bible"]["Lam"]="Lamentations";
$wgSacredChapterAlias["Christian Bible"]["Lev"]="Leviticus";
$wgSacredChapterAlias["Christian Bible"]["Luk"]="Luke";
$wgSacredChapterAlias["Christian Bible"]["Mal"]="Malachi";
$wgSacredChapterAlias["Christian Bible"]["Mar"]="Mark";
$wgSacredChapterAlias["Christian Bible"]["Mat"]="Matthew";
$wgSacredChapterAlias["Christian Bible"]["Mic"]="Micah";
$wgSacredChapterAlias["Christian Bible"]["Nah"]="Nahum";
$wgSacredChapterAlias["Christian Bible"]["Neh"]="Nehemiah";
$wgSacredChapterAlias["Christian Bible"]["Num"]="Numbers";
$wgSacredChapterAlias["Christian Bible"]["Oba"]="Obad";
$wgSacredChapterAlias["Christian Bible"]["Phi"]="Philemon";
$wgSacredChapterAlias["Christian Bible"]["Phi"]="Philippians";
$wgSacredChapterAlias["Christian Bible"]["Pro"]="Proverbs";
$wgSacredChapterAlias["Christian Bible"]["Psa"]="Psalms";
$wgSacredChapterAlias["Christian Bible"]["Psalm"]="Psalms";
$wgSacredChapterAlias["Christian Bible"]["Rev"]="Revelation";
$wgSacredChapterAlias["Christian Bible"]["Rom"]="Romans";
$wgSacredChapterAlias["Christian Bible"]["Rut"]="Ruth";
$wgSacredChapterAlias["Christian Bible"]["Son"]="Song of Solomon";
$wgSacredChapterAlias["Christian Bible"]["Song"]="Song of Solomon";
$wgSacredChapterAlias["Christian Bible"]["SSol"]="Song of Solomon";
$wgSacredChapterAlias["Christian Bible"]["Tit"]="Titus";
$wgSacredChapterAlias["Christian Bible"]["Zec"]="Zechariah";
$wgSacredChapterAlias["Christian Bible"]["Zep"]="Zephaniah";
 
$wgHooks['ParserFirstCallInit'][] = 'efSacredTextParserInit';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'updateSacredTextDB';
$wgMessagesDirs['SacredText'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['SacredTextMagic'] = __DIR__ . '/SacredText.i18n.magic.php';

function efSacredTextParserInit( $parser ) {
	global $wgSacredUseBibleTag;
	$parser->setHook( 'sacredtext', 'SacredTextLookup::hookSacredText' );
	$parser->setFunctionHook( 'sacredtext', 'SacredTextLookup::parserFunctionHookSacredText' );
	if( $wgSacredUseBibleTag ) {
		$parser->setHook( 'bible', 'SacredTextLookup::hookBible' );
		$parser->setFunctionHook( 'bible', 'SacredTextLookup::parserFunctionHookBible' );
	}
	return true;
}
 
function updateSacredTextDB( DatabaseUpdater $updater ) {
	if ( $updater->getDB()->getType() == 'mysql' || $updater->getDB()->getType() == 'sqlite' ) {
		$updater->addExtensionTable( 'sacredtext_verses', __DIR__ . '/SacredText.verses.sql' );
	}

	return true;
}
