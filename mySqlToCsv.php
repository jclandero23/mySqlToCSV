<?php
class sqlToCsv
{
	public static $DATOS_INVALIDOS = 'Datos no encontrados para generar archivo';
	
	public static function toStr($mysql_query, $nl = "\n")
	{
		$result = $mysql_query;
		$output = '';
			$i = 0;
		if (!$result)
		{
			$output = '"Error: ", "'.mysql_error().'"';
			return $output;
			//$message = 'ERROR:' . mysql_error();
			//return $message;
		}
		else
		{
			for($i = 0; $i < mysql_num_fields($result); $i++)
			{
				$meta = mysql_fetch_field($result, $i);
				$output .=  '"' . $meta->name . '",';
			}
			$output = substr($output, 0, strlen($output)-1);
		
			while ($row = mysql_fetch_row($result))
			{
				$count = count($row);
				$output .= $nl;
				for($y = 0; $y < $count; $y++)
				{
					$c_row = current($row);
					$output .= '"' . str_replace('"', '\"', $c_row) . '",';
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
			$output = self::$DATOS_INVALIDOS;
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