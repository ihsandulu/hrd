<?php
$tonbrondol = array();
$tontbs = array();
$bjrs = array();
$sptbs = $this->db
    ->table("sptbs")
    ->where("sptbs_id", $_GET["sptbs_id"])
    ->get()
    ->getRow();
$isbrondol = $sptbs->sptbs_isbrondol;
$istbs = $sptbs->sptbs_istbs;

if ($isbrondol == 1 && $istbs == 1) {
} else if ($isbrondol == 1 && $istbs == 0) {
} else if ($isbrondol == 0 && $istbs == 1) {
}

//rumus ambil tonase per tph
$panen = $this->db
        ->table("panen")
        ->get();
    foreach ($panen->getResult() as $panen) {
        $panen_id = $panen->panen_id;
        //brondol
        $tonbrondol[$panen->panen_id] = $panen->panen_jml * 16;
        //tbs
        $panen = $this->db
            ->table("panen")
            ->where("tph_id", $panen->tph_id)
            ->where("SUBSTRING(panen_date,1,7)", substr($panen->panen_date, 0, 7))
            ->get();
        if ($panen->getCount() > 0) {
            $bjrs[$panen->panen_id] = $panen->getRow()->panen_bjr;
        } else {
            $tph = $this->db
                ->table("tph")
                ->where("tph_id", $panen->tph_id)
                ->get()
                ->getRow();
            $bjrs[$panen->panen_id] = $tph->tph_bjr;
        }
        $tontbs=$panen->panen_jml *$bjrs[$panen->panen_id];

    }

