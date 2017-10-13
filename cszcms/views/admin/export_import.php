<?php if($this->uri->segment(4) && $this->db->table_exists($this->uri->segment(4))) { 
    $seloptdata[''] = '-- '.$this->lang->line('option_no').' --';
    if (!empty($fields)) {
        foreach ($fields as $val) {
            $seloptdata[$val] = (in_array($val, (array)$primary_key)) ? $val .' &#9919;' : $val;
        }
    }
    ?>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="h2 sub-header"><?php echo $this->lang->line('db_table_name') ?>: <?php echo $this->uri->segment(4) ?> <a role="button" href="<?php echo $this->csz_referrer->getIndex('export')?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $this->lang->line('btn_back') ?></a></div>
            <?php echo form_open_multipart($this->Csz_model->base_link(). '/admin/export/importdb/'.$this->uri->segment(4)) ?>
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title"><b><?php echo $this->lang->line('import_csv_header') ?></b></h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <?php $i = 0; ?>
                <div class="box-body">
                    <div class="box box-body table-responsive no-padding">
                        <table class="table table-bordered table-hover table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="vertical-align:middle;">#</th>
                                <?php if (!empty($csvfields)) { foreach ($csvfields as $key) { ?>
                                    <th class="text-center" style="vertical-align:middle;">
                                        <?php echo $key; ?><br>
                                        <?php
                                        $att = 'id="field-'.$key.'" class="form-control"';
                                        echo form_dropdown('field['.$key.']', $seloptdata, $key, $att);
                                        ?>
                                    </th>
                                <?php } } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($csvdata)) { ?>
                                    <?php
                                    foreach ($csvdata as $row) {
                                        if($i >= 50){
                                            break;
                                        }
                                        echo '<tr>';
                                        echo '<td class="text-center" style="vertical-align:middle;">'.($i+1).'</td>';
                                        foreach ($row as $key => $val) {
                                            echo '<td class="text-center" style="vertical-align:middle;">';
                                            echo $val;
                                            echo '</td>';
                                        }
                                        echo '</tr>';
                                        $i++;
                                    }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <b><?php echo $this->lang->line('total').' '.$data_count.' '.$this->lang->line('records');?></b>
                    <br><br>
                    <input name="csvfile" value="<?php echo $csvfile?>" id="csvfile" type="hidden">
                    <label for="csv_ignore"><input name="csv_ignore" value="1" id="csv_ignore" type="checkbox" checked> &#9919; <?php echo $this->lang->line('import_csv_ignore') ?>.</label><br><br>
                </div>
                <div class="box-footer">
                    <?php
                        $data = array(
                            'name' => 'submit',
                            'id' => 'submit',
                            'class' => 'btn btn-primary',
                            'value' => $this->lang->line('import_csv_btn'),
                            'onclick' => "return confirm('" . $this->lang->line('delete_message') . "');",
                        );
                        echo form_submit($data); ?> &nbsp;&nbsp;&nbsp; 
                        <a role="button" href="<?php echo $this->csz_referrer->getIndex('export')?>" class="btn btn-default"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $this->lang->line('btn_cancel') ?></a>
                </div>
            </div>
            <?php echo form_close(); ?>
            <!-- /.box -->       
        </div>
    </div>
<?php }
