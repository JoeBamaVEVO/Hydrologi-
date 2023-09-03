<div class="container">
    <form method="POST">
        <h2>Hydrologi '. $project .'</h2>
        <div class="FormLeft">
            <label class="col-form-label d-flex justify-content-end "for="Malestasjon">Målestasjon</label>
            <select class="form-control" name="Malestasjon" value="Klvtveitvatn.csv">
                ' . $Malestasjoner .'
            </select>
            <!-- AntallMålinger -->
            <label class="col-form-label d-flex justify-content-end" for="AntallMålinger">Antall Målinger</label>
            <input class="form-control" type="number" name="AntallMålinger" value="1">
            <!-- Qmiddel -->
            <label class="col-form-label d-flex justify-content-end" for="Qmiddel">Qmiddel</label>
            <input class="form-control" type="number" name="Qmiddel" value="' . $Qmiddel . '" step="0.01" >
            <small class="form-text col-1">m3/s km2</small>
            <!-- FeltAreal -->
            <label class="col-form-label d-flex justify-content-end" for="FeltAreal">Felt Areal</label>
            <input class="form-control" type="number" name="FeltAreal" value="' . $FeltAreal .'" step="0.01">
            <small class="form-text col-1">km2</small>
            <!-- SnaufjellsAndel -->
            <label class="col-form-label d-flex justify-content-end pt-0" for="SnaufjellsAndel">Snaufjellsandel</label>
            <input class="form-control" type="number" name="SnaufjellsAndel" value="' . $SnaufjellsAndel .'" step="0.01">
            <small class="form-text col-1">%</small>
            <!-- EffSjoandel -->
            <label class="col-form-label d-flex justify-content-end pt-0" for="EffSjøandel">Effektiv Sjøandel</label>
            <input class="form-control" type="number" name="EffSjoandel" value="' . $EffSjoandel . '" step="0.01">
            <small class="form-text col-1">%</small>
            <!-- MaxKvote -->
            <label class="col-form-label d-flex justify-content-end pt-0" for="MaxKvote">Max Kvote Felt</label>
            <input class="form-control" type="number" name="MaxKvote" value="'. $MaxKvote .'" step="0.01">
            <small>m.o.h</small>
            <!-- MinKvote -->
            <label class="col-form-label d-flex justify-content-end pt-0" for="MinKvote">Min Kvote Felt</label>
            <input class="form-control" type="number" name="MinKvote" value="'.$MinKvote.'" step="0.01">
            <small class="form-text col-1">m.o.h</small>
        </div>
        <div class="FromRight">
            <!-- Prosjekt -->
            <label class="col-form-label  d-flex justify-content-end" for="">Prosjekt</label>
            <input class="form-control" type="text" name="" value="' . $project . '" disabled> 
            <!-- AntallMålinger -->
            <label class="col-form-label  d-flex justify-content-end" for="ProsjAntallMålinger">Antall Målinger</label>
            <input class="form-control" type="number" name="ProsjAntallMalinger" value="1">
            <!-- Qmiddel -->
            <label class="col-form-label  d-flex justify-content-end" for="">Qmiddel</label>
            <input class="form-control" type="number" name="ProsjQmiddel"  value="' . $ProsjQmiddel . '" step="0.01">
            <!-- FeltAreal -->
            <label class="col-form-label  d-flex justify-content-end" for="ProsjFeltAreal">Felt Areal</label>
            <input class="form-control" type="number" name="ProsjFeltAreal" value="'.$ProsjFeltAreal.'" step="0.01">
            <!-- Snaufjellsandel -->    
            <label class="col-form-label  d-flex justify-content-end" for="ProsjSnaufjellsAndel">Snaufjellsandel</label>
            <input class="form-control" type="number" name="ProsjSnaufjellsAndel" value="'.$ProsjSnaufjellsAndel.'" step="0.01">
            <!-- EffSjøandel -->
            <label class="col-form-label  d-flex justify-content-end" for="ProsjEffSjoandel">Effektiv Sjøandel</label>
            <input class="form-control" type="number" name="ProsjEffSjoandel" value="' . $ProsjEffSjoandel . '" step="0.01">    
            <!--MaxKvote  -->
            <label class="col-form-label  d-flex justify-content-end" for="ProsjMaxKvote">Max Kvote Felt</label>
            <input class="form-control" type="number" name="ProsjMaxKvote" value="'. $ProsjMaxKvote .'" step="0.01">
            <!-- MinKvote -->
            <label class="col-form-label  d-flex justify-content-end" for="ProsjMinKvote">Min Kvote Felt</label>
            <input class="form-control" type="number" name="ProsjMinKvote" value="'.$ProsjMinKvote.'" step="0.01">

            <!-- FeltLendge -->
            <label class="col-form-label d-flex justify-content-end" for="ProsjFeltlengde">Feltlengde</label>
            <input class="form-control" type="number" name="ProsjFeltlengde" value="'.$ProsjFeltlengde.'" step="0.01">

            <!-- sjøandel -->
            <label class="col-form-label d-flex justify-content-end" for="ProsjSjoandel">Sjøandel</label>
            <input class="form-control" type="number" name="ProsjSjoandel" value="'.$ProsjSjoandel.'" step="0.01">
        </div>
            <div class="col-2">
                <button name="hentMetadata" type="submit" class="ms-5 btn btn-primary">
                    Hent Metadata
                </button>
            </div>
            <div class="col-2">
                <button name="lagreMetadata" type="submit" class="ms-5 btn btn-primary">
                    Lagre Metadata
                </button>
            </div>
            <div class="col-5">
                <button name="lagreProsjekt" type="submit" class="float-end ms-5 btn btn-primary">
                    Lagre Prosjekt
                </button>
            </div>
            <div class="col-2">
                <button name="hentProsjektData" type="submit" class="ms-5 btn btn-primary">
                    Oppdater prosj data
                </button>
            </div> 
        </div>
    </form>
</div>


<div class="FormLeft">
    <label class="col-form-label d-flex justify-content-end "for="Malestasjon">Målestasjon</label>
    <select class="form-control" name="Malestasjon" value="Klvtveitvatn.csv">
        ' . $Malestasjoner .'
    </select>
    <!-- AntallMålinger -->
    <label class="col-form-label d-flex justify-content-end" for="AntallMålinger">Antall Målinger</label>
    <input class="form-control" type="number" name="AntallMålinger" value="1">
    <!-- Qmiddel -->
    <label class="col-form-label d-flex justify-content-end" for="Qmiddel">Qmiddel</label>
    <div class="input-group"> 
        <input class="form-control" type="number" name="Qmiddel" value="' . $Qmiddel . '" step="0.01" >
        <small class="form-text col-1">m3/s km2</small>
    </div>
    <!-- FeltAreal -->
    <label class="col-form-label d-flex justify-content-end" for="FeltAreal">Felt Areal</label>
    <div class="input-group">
        <input class="form-control" type="number" name="FeltAreal" value="' . $FeltAreal .'" step="0.01">
        <small class="form-text col-1">km2</small>
    </div>
    <!-- SnaufjellsAndel -->
    <label class="col-form-label d-flex justify-content-end pt-0" for="SnaufjellsAndel">Snaufjellsandel</label>
    <div class="input-group">
        <input class="form-control" type="number" name="SnaufjellsAndel" value="' . $SnaufjellsAndel .'" step="0.01">
        <small class="form-text col-1">%</small>
    </div>
    <!-- EffSjoandel -->
    <label class="col-form-label d-flex justify-content-end pt-0" for="EffSjøandel">Effektiv Sjøandel</label>
    <div class="input-group">
        <input class="form-control" type="number" name="EffSjoandel" value="' . $EffSjoandel . '" step="0.01">
        <small class="form-text col-1">%</small>
    </div>
    <!-- MaxKvote -->
    <label class="col-form-label d-flex justify-content-end pt-0" for="MaxKvote">Max Kvote Felt</label>
    <div class="input-group">
        <input class="form-control" type="number" name="MaxKvote" value="'. $MaxKvote .'" step="0.01">
        <small>m.o.h</small>
    </div>
    <!-- MinKvote -->
    <label class="col-form-label d-flex justify-content-end pt-0" for="MinKvote">Min Kvote Felt</label>
    <div class="input-group">
        <input class="form-control" type="number" name="MinKvote" value="'.$MinKvote.'" step="0.01">
        <small class="form-text col-1">m.o.h</small>
    </div>
    <!-- HentMeta -->
    <button name="hentMetadata" type="submit" class="ms-5 btn btn-primary">
    Hent Metadata
    </button>
    <!-- LagreMeta -->
    <button name="lagreMetadata" type="submit" class="ms-5 btn btn-primary">
        Lagre Metadata
    </button>
</div>