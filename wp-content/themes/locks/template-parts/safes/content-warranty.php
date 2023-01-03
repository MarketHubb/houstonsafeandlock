<div class="warranty my-4">
    <p class="small fw-600 px-2  d-inline bg-grey border border-1 border rounded">Warranty:</p>
    <ul class="list-group list-group-flush list-group-horizontal no-border ms-0 ps-0 mt-1 d-inline-block ms-3">
        <?php $warranty_items = get_warranty_information(get_the_ID()); ?>
        <?php foreach ($warranty_items as $key => $val) { ?>
            <li class="list-group-item flex-fill no-border ps-0 py-0 bg-transparent d-inline-block">
                <p class="small fw-600 d-inline"><?php echo $key; ?>:</p>
                <p class="small d-block d-md-inline"><?php echo $val; ?></p>
            </li>
        <?php } ?>
    </ul>
</div>
