<?php
$getID3->setOption(array('encoding'=>$TaggingFormat));

getid3_lib::IncludeDependency(GETID3_INCLUDEPATH.'write.php', __FILE__, true);

$browsescriptfilename = '?page=modi&mode=idtag';

$Filename = (isset($_REQUEST['Filename']) ? $_REQUEST['Filename'] : '');

if (isset($_POST['WriteTags'])) {

	$TagFormatsToWrite = (isset($_POST['TagFormatsToWrite']) ? $_POST['TagFormatsToWrite'] : array());
	if (!empty($TagFormatsToWrite)) {
		echo 'Starte Tag-bearbeitung<BR>';

		$tagwriter = new getid3_writetags;
		$tagwriter->filename       = $Filename;
		$tagwriter->tagformats     = $TagFormatsToWrite;
		$tagwriter->overwrite_tags = true;
		$tagwriter->tag_encoding   = $TaggingFormat;
		if (!empty($_POST['remove_other_tags'])) {
			$tagwriter->remove_other_tags = true;
		}

		$commonkeysarray = array('Title', 'Artist', 'Album', 'Year', 'Comment');
		foreach ($commonkeysarray as $key) {
			if (!empty($_POST[$key])) {
				$TagData[strtolower($key)][] = $_POST[$key];
			}
		}
		if (!empty($_POST['Track'])) {
			$TagData['track'][] = $_POST['Track'].(!empty($_POST['TracksTotal']) ? '/'.$_POST['TracksTotal'] : '');
		}

		if (!empty($_FILES['userfile']['tmp_name'])) {
			if (in_array('id3v2.4', $tagwriter->tagformats) || in_array('id3v2.3', $tagwriter->tagformats) || in_array('id3v2.2', $tagwriter->tagformats)) {
				if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
					ob_start();
					if ($fd = fopen($_FILES['userfile']['tmp_name'], 'rb')) {
						ob_end_clean();
						$APICdata = fread($fd, filesize($_FILES['userfile']['tmp_name']));
						fclose ($fd);

						list($APIC_width, $APIC_height, $APIC_imageTypeID) = GetImageSize($_FILES['userfile']['tmp_name']);
						$imagetypes = array(1=>'gif', 2=>'jpeg', 3=>'png');
						if (isset($imagetypes[$APIC_imageTypeID])) {

							$TagData['attached_picture'][0]['data']          = $APICdata;
							$TagData['attached_picture'][0]['picturetypeid'] = $_POST['APICpictureType'];
							$TagData['attached_picture'][0]['description']   = $_FILES['userfile']['name'];
							$TagData['attached_picture'][0]['mime']          = 'image/'.$imagetypes[$APIC_imageTypeID];

						} else {
							echo '<b>Falsches Bildformat (GIF, JPEG, PNG)</b><br>';
						}
					} else {
						$errormessage = ob_get_contents();
						ob_end_clean();
						echo '<b>Konnte nicht ge&ouml;ffnet werden '.$_FILES['userfile']['tmp_name'].'</b><br>';
					}
				} else {
					echo '<b>!is_uploaded_file('.$_FILES['userfile']['tmp_name'].')</b><br>';
				}
			} else {
				echo '<b>WARNING:</b> Nur ID3v2 k&ouml;nnen Bilder verwendet werden<br>';
			}
		}

		$tagwriter->tag_data = $TagData;
		if ($tagwriter->WriteTags()) {
			echo 'Tags erfolgreich geschrieben.<BR>';
			if (!empty($tagwriter->warnings)) {
				echo 'Es sind Fehler aufgetreten:<BLOCKQUOTE STYLE="background-color:#FFCC33; padding: 10px;">'.implode('<br><br>', $tagwriter->warnings).'</BLOCKQUOTE>';
			}
		} else {
			echo 'Fehler beim Schreiben der Tags!<BLOCKQUOTE STYLE="background-color:#FF9999; padding: 10px;">'.implode('<br><br>', $tagwriter->errors).'</BLOCKQUOTE>';
		}

	} else {

		echo 'WARNING: Keine Tags ausgew&auml;hlt, keine Ver&auml;nderung vorgenommen!';

	}
	echo '<HR>';

}


echo '<div style="font-size: 1.2em; font-weight: bold;">Tags Bearbeiten</div>';
echo '<a href="'.htmlentities($browsescriptfilename.'&listdirectory='.rawurlencode(realpath(dirname($Filename))), ENT_QUOTES).'">Zum Aktuellen Verzeichnis zur&uuml;ck</a><br>';
if (!empty($Filename)) {
	echo '<form action="" method="post" enctype="multipart/form-data">';	
	echo "<input type='hidden' name='page' value='modi'>";
	echo "<input type='hidden' name='mode' value='idtag'>";
	echo '<table border="3" cellspacing="0" cellpadding="4">';
	echo '<tr>
			<th align="right">Dateiname:</th>
			<td><input type="hidden" name="Filename" value="'.htmlentities($Filename, ENT_QUOTES).'"><a href="'.htmlentities($browsescriptfilename.'&filename='.rawurlencode($Filename), ENT_QUOTES).'" target="_blank">'.$Filename.'</a></td>
		</tr>';
	if (file_exists($Filename)) {

		// Initialize getID3 engine
		$getID3 = new getID3;
		$OldThisFileInfo = $getID3->analyze($Filename);
		getid3_lib::CopyTagsToComments($OldThisFileInfo);

		switch ($OldThisFileInfo['fileformat']) {
			case 'mp3':
			case 'mp2':
			case 'mp1':
				$ValidTagTypes = array('id3v1', 'id3v2.3', 'ape');
				break;

			case 'mpc':
				$ValidTagTypes = array('ape');
				break;

			case 'ogg':
				if (!empty($OldThisFileInfo['audio']['dataformat']) && ($OldThisFileInfo['audio']['dataformat'] == 'flac')) {
					//$ValidTagTypes = array('metaflac');
					// metaflac doesn't (yet) work with OggFLAC files
					$ValidTagTypes = array();
				} else {
					$ValidTagTypes = array('vorbiscomment');
				}
				break;

			case 'flac':
				$ValidTagTypes = array('metaflac');
				break;

			case 'real':
				$ValidTagTypes = array('real');
				break;

			default:
				$ValidTagTypes = array();
				break;
		}
		echo '<tr>
				<td align="right"><b>Titel</b></td> 
				<td><input type="text" size="40" name="Title"  value="'.htmlentities((!empty($OldThisFileInfo['comments']['title'])  ? implode(', ', $OldThisFileInfo['comments']['title'] ) : ''), ENT_QUOTES).'"></td>
			</tr>';
		echo '<tr>
				<td align="right"><b>Interpret</b></td>
				<td><input type="text" size="40" name="Artist" value="'.htmlentities((!empty($OldThisFileInfo['comments']['artist']) ? implode(', ', $OldThisFileInfo['comments']['artist']) : ''), ENT_QUOTES).'"></td>
			</tr>';
		echo '<tr>
				<td align="right"><b>Album</b></td>
				<td><input type="text" size="40" name="Album"  value="'.htmlentities((!empty($OldThisFileInfo['comments']['album'])  ? implode(', ', $OldThisFileInfo['comments']['album'] ) : ''), ENT_QUOTES).'"></td>
			</tr>';
		echo '<tr>
				<td align="right"><b>Jahr</b></td>  
				<td><input type="text" size="4"  name="Year"   value="'.htmlentities((!empty($OldThisFileInfo['comments']['year'])   ? implode(', ', $OldThisFileInfo['comments']['year']  ) : ''), ENT_QUOTES).'"></td>
			</tr>';

		$TracksTotal = '';
		$TrackNumber = '';
		if (!empty($OldThisFileInfo['comments']['track_number']) && is_array($OldThisFileInfo['comments']['track_number'])) {
			$RawTrackNumberArray = $OldThisFileInfo['comments']['track_number'];
		} elseif (!empty($OldThisFileInfo['comments']['track']) && is_array($OldThisFileInfo['comments']['track'])) {
			$RawTrackNumberArray = $OldThisFileInfo['comments']['track'];
		} else {
			$RawTrackNumberArray = array();
		}
		foreach ($RawTrackNumberArray as $key => $value) {
			if (strlen($value) > strlen($TrackNumber)) {
				// ID3v1 may store track as "3" but ID3v2/APE would store as "03/16"
				$TrackNumber = $value;
			}
		}

		echo '<tr><td align="right"><b>Schreibe Tags</b></td><td>';
		foreach ($ValidTagTypes as $ValidTagType) {
			echo '<input type="checkbox" name="TagFormatsToWrite[]" value="'.$ValidTagType.'"';
			if (count($ValidTagTypes) == 1) {
				echo ' checked="checked"';
			} else {
				switch ($ValidTagType) {
					case 'id3v2.2':
					case 'id3v2.3':
					case 'id3v2.4':
						if (isset($OldThisFileInfo['tags']['id3v2'])) {
							echo ' checked="checked"';
						}
						break;

					default:
						if (isset($OldThisFileInfo['tags'][$ValidTagType])) {
							echo ' checked="checked"';
						}
						break;
				}
			}
			echo '>'.$ValidTagType.'<br>';
		}
		if (count($ValidTagTypes) > 1) {
			echo '<hr><input type="checkbox" name="remove_other_tags" value="1">L&ouml;sche nicht relevante TAGs beim Speichern.<br>';
		}
		echo '</td></tr>';

		echo '<tr>
				<td align="right"><b>Kommentar</b></td>
				<td><textarea cols="30" rows="3" name="Comment" wrap="virtual">'.((isset($OldThisFileInfo['comments']['comment']) && is_array($OldThisFileInfo['comments']['comment'])) ? implode("\n", $OldThisFileInfo['comments']['comment']) : '').'</textarea></td>
			</tr>';

		echo '<tr>
				<td align="right"><b>Cover</b><br>(ID3v2 only)</td>
				<td><input type="file" name="userfile" accept="image/jpeg, image/gif, image/png"><br>';
		echo '<select name="APICpictureType">';
		$APICtypes = getid3_id3v2::APICPictureTypeLookup('', true);
		foreach ($APICtypes as $key => $value) {
			echo '<option value="'.htmlentities($key, ENT_QUOTES).'">'.htmlentities($value).'</option>';
		}
		echo '</select></td>
			</tr>';
		echo '<tr>
				<td align="center" colspan="2"><input type="submit" name="WriteTags" value="Speichern"> ';
		echo '<input type="reset" value="Abbrechen"></td></tr>';

	} else {

		echo '<tr><td align="right"><b>Error</b></td><td>'.htmlentities($Filename).' existiert nicht!</td></tr>';

	}
	echo '</table>';
	echo '</form>';

}
?>
