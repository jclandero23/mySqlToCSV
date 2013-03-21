<?php
class sqlToCsv
{
	public static $INVALID_DATA = 'INVALID SQL RESULT';
	
	public static function toStr($mysql_query, $nl = "\n")
	{
		$result = $mysql_query;
		$output = '';
			$i = 0;
		if (!$result)
		{
			$output = 'ERROR "'.mysql_error().'"';
			return $output;
		}
		else
		{
			for($i = 0; $i < mysql_num_fields($result); $i++)
			{
				$meta = mysql_fetch_field($result, $i);
				$contiene_coma = false;
				if(strpos($meta->name, ",") !== false)
					$contiene_coma = true;

				$output .= $contiene_coma ? '"' : '';
				if($contiene_coma)
					$output .= str_replace('"', '""', $meta->name);
				else
					$output .= $meta->name;
				$output .= $contiene_coma ? '",' : ',';
			}
			$output = substr($output, 0, strlen($output)-1);
		
			while ($row = mysql_fetch_row($result))
			{
				$count = count($row);
				$output .= $nl;
				for($y = 0; $y < $count; $y++)
				{
					$c_row = current($row);
					$contiene_coma = false;
					if(strpos($c_row, ",") !== false)
						$contiene_coma = true;

					$output .= $contiene_coma ? '"' : '';
					if($contiene_coma)
						$output .= str_replace('"', '""', $c_row);
					else
						$output .= $c_row;
					$output .= $contiene_coma ? '",' : ',';
					next($row);
				}
				$output = substr($output, 0, strlen($output)-1);
			}
			mysql_free_result($result);
		}
		return $output;
	}
	
	public static function toFile($mysql_query, $filename, $ext = 'CSV', $charset = 'ISO-8859-1', $nl = '\n')
	{
		if (!$mysql_query)
		{
			//$output = self::$INVALID_DATA;
			$output = 'ERROR: '.self::$INVALID_DATA;
			return $output;
		}
		else
		{
			header("Cache-Control: public");
			header('Content-Type: text/csv; charset='.$charset);
			header('Content-Disposition: attachment; filename='.$filename.'.'.$ext);
			echo self::toStr($mysql_query);
		}
	}
}
?>