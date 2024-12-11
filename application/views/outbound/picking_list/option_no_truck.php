<option value="">--No Truck--</option>
<?php
foreach ($ekspedisi->result() as $eks) {
?>
    <option value="<?= $eks->no_truck ?>" data-name="<?= $eks->name ?>" data-id="<?= $eks->id ?>"><?= $eks->no_truck ?></option>
<?php
}
?>