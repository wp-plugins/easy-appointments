<script>
    window.eaData = {};
    var ea = window.eaData;
    ea.Locations = <?php echo EADBModels::get_pre_cache_json('ea_locations'); ?>;
    ea.Services = <?php echo EADBModels::get_pre_cache_json('ea_services'); ?>;
    ea.Workers = <?php echo EADBModels::get_pre_cache_json('ea_staff'); ?>;
    ea.MetaFields = <?php echo EADBModels::get_pre_cache_json('ea_meta_fields', array('position' => 'ASC')); ?>;
    ea.Status = <?php echo json_encode(EALogic::getStatus()); ?>
</script>