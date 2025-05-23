<?php
/**
 * Parse RSS
 *
 * @package daily-pleroma
 */

function parse_pleroma_atom( $url ){
	$atom = new SimpleXMLElement( $url, LIBXML_COMPACT | LIBXML_NOERROR, true );

	foreach( $atom->entry as $entry ){
		$date = new DateTime( $entry->published );
		$date->setTimeZone(new DateTimeZone('Asia/Tokyo'));
		$key = $date->format( 'c' );
		
		foreach ( $entry->link as $link ){
			if( 'text/html' === (string) $link['type'] ){
				$url = (string) $link['href'];
				break;
			};
		}

		$items[ $key ] = array(
			'link' => $url,
			'content' => (string) $entry->content,
		);
	}

	return $items;
}
