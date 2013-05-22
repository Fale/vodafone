<?php

class CsvController extends BaseController {

	public function to($to = 'z')
	{
		return $this->all('0', $to);
	}
	
	public function all($from = "0", $to = 'z')
	{

/*return DB::table("vodafone")
	->select("COUNT(*) as PerCount")
	->select(function($query)
	{
		$query->'SUM(CASE tipo WHEN "Servizi di messaggistica" THEN 1 ELSE 0 END)'))
	}
	->select(DB::RAW('SUM(CASE tipo WHEN "Chiamate voce e video" THEN 1 ELSE 0 END)'))
	->where("tipo", "Servizi di messaggistica")
	->orwhere("tipo", "Chiamate voce e video")
	->groupBy("numero")
	->orderBy("PerCount", "desc")
	->take(10);
*/
		$numbers =  DB::table('vodafone')
				      ->select('numero', DB::raw('COUNT(*) as PerCount'))
				      ->whereBetween('data', array($from, $to))
   			          ->where(function($query)
            		  {
                          $query->where('tipo', "Servizi di messaggistica" )
				      			->orWhere('tipo', "Chiamate voce e video");
                      })
				      ->groupBy('numero')
				      ->orderBy('PerCount', 'desc')
				      ->take(10)
				      ->get();

		$out = "State,Totale,Chiamate,SMS";
		foreach ($numbers as $number) {
			$out .= "\n";
			$out .= $number->numero . ',';
			$out .= $number->PerCount . ',';
			$out .= DB::table('vodafone')
			          ->where('numero', $number->numero)
			          ->where('tipo', "Chiamate voce e video")
			          ->whereBetween('data', array($from, $to))
			          ->count() . ',';
			$out .= DB::table('vodafone')
			          ->where('numero', $number->numero)
			          ->where('tipo', "Servizi di messaggistica")
			          ->whereBetween('data', array($from, $to))
			          ->count();
		}
		return Response::make($out, 200, array('Content-Type' => 'text/plain'));
	}

	public function number($n)
	{
		$numbers =  DB::table('vodafone')
				      ->select(DB::raw('CONCAT(MONTH(data), "-", YEAR(data)) as period'),
				      		   DB::raw('COUNT(*) as PerCount'))
				      ->where('numero', $n)
   			          ->where(function($query)
            		  {
                          $query->where('tipo', "Servizi di messaggistica" )
				      			->orWhere('tipo', "Chiamate voce e video");
                      })
				      ->groupBy(DB::raw('CONCAT(MONTH(data), "-", YEAR(data))'))
				      ->orderBy(DB::raw('CONCAT(YEAR(data), "-", MONTH(data))'))
				      ->get();

		$out = "State,Totale,Chiamate,SMS";
		foreach ($numbers as $number) {
			$out .= "\n";
			$out .= $number->period . ',';
			$out .= $number->PerCount . ',';
			$out .= DB::table('vodafone')
			          ->where('numero', $n)
			          ->where('tipo', "Chiamate voce e video")
			          ->whereRaw('CONCAT(MONTH(data), "-", YEAR(data)) = \'' . $number->period . '\'')
			          ->count() . ',';
			$out .= DB::table('vodafone')
			          ->where('numero', $n)
			          ->whereRaw('CONCAT(MONTH(data), "-", YEAR(data)) = \'' . $number->period . '\'')
			          ->where('tipo', "Servizi di messaggistica")
			          ->count();
		}
		return Response::make($out, 200, array('Content-Type' => 'text/plain'));
	}

}
