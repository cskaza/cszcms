<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-globe"></span></i> <?php echo  $this->lang->line('forms_view') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $form_name?>  <a role="button" href="<?php echo $this->Csz_model->base_link().'/admin/forms/dataAdd/'.$this->uri->segment(4) ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo $this->lang->line('btn_add');?></a> <a role="button" href="<?php echo $this->csz_referrer->getIndex('admin_form_view')?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $this->lang->line('btn_back') ?></a></div>
        <?php echo form_open_multipart($this->Csz_model->base_link(). '/admin/forms/dataInsert/'.$this->uri->segment(4)); ?>
        <?php $html = '';
        if ($field_data !== FALSE) {
            foreach ($field_data as $field) {
                if ($field['field_required']) {
                    $f_req = ' required="required"';
                    $star_req = ' <i style="color:red;">*</i>';
                } else {
                    $f_req = '';
                    $star_req = '';
                }
                if ($field['field_type'] == 'email' || $field['field_type'] == 'password' || $field['field_type'] == 'text') {
                    $length_att = '';
                    $maxlength = '';
                    if ($field['sel_option_val']) {
                        if ($field['sel_option_val']) {
                            $opt_arr = explode(",", str_replace(' ', '', $field['sel_option_val']));
                            foreach ($opt_arr as $opt) {
                                list($maxlengthnum, $minlengthnum) = explode("=>", $opt);
                                if (is_numeric($maxlengthnum) && $maxlengthnum > 0) {
                                    $maxlength .= ' maxlength="' . $maxlengthnum . '"';
                                }
                                if (is_numeric($minlengthnum) && $minlengthnum > 0) {
                                    $maxlength .= ' minlength="' . $minlengthnum . '"';
                                }
                                break;
                            }
                        }
                    } else {
                        $maxlength = ' maxlength="255"';
                    }
                } else {
                    $maxlength = '';
                }
                if ($field['field_type'] == 'number' || $field['field_type'] == 'email' || $field['field_type'] == 'file' || $field['field_type'] == 'password' || $field['field_type'] == 'text') {
                    if ($field['field_type'] == 'file' && ($field['sel_option_val'] == NULL || empty($field['sel_option_val']))) {
                        $accept = ' accept="' . $this->Csz_model->getMines() . '"';
                    } else if ($field['field_type'] == 'file' && ($field['sel_option_val'] != NULL && $field['sel_option_val'])) {
                        $accept = ' accept="' . $this->Csz_model->getMines($field['sel_option_val']) . '"';
                    } else {
                        $accept = '';
                    }
                    if ($field['field_type'] == 'number' && $field['sel_option_val']) {
                        if ($field['sel_option_val']) {
                            $opt_arr = explode(",", str_replace(' ', '', $field['sel_option_val']));
                            foreach ($opt_arr as $opt) {
                                list($maxlengthnum, $minlengthnum) = explode("=>", $opt);
                                if (is_numeric($maxlengthnum) && is_numeric($minlengthnum) && $maxlengthnum > 0 && $minlengthnum > 0) {
                                    $num_att = ' max="' . $maxlengthnum . '" min="' . $minlengthnum . '"';
                                }
                                break;
                            }
                        }
                    } else if ($field['field_type'] == 'number' && !$field['sel_option_val']) {
                        $num_att = ' max="9999999999999999999999999999999999999999"';
                    } else {
                        $num_att = '';
                    }
                    $html .= '<div' . (($field['field_div_class']) ? ' class="' . $field['field_div_class'] . '"' : '') . '>';
                    $html .= '<label class="control-label" for="' . $field['field_id'] . '">' . $field['field_label'] . $star_req . '</label>
                        <div class="controls">
                            <input type="' . $field['field_type'] . '" name="' . $field['field_name'] . '" value="' . $field['field_value'] . '" id="' . $field['field_id'] . '" class="' . $field['field_class'] . '" placeholder="' . $field['field_placeholder'] . '"' . $f_req . $maxlength . $accept . $num_att . '/>
                        </div>';
                    $html .= '</div>';
                } else if ($field['field_type'] == 'checkbox') {
                    $html .= '<div' . (($field['field_div_class']) ? ' class="' . $field['field_div_class'] . '"' : '') . '>';
                    $html .= '<label for="' . $field['field_id'] . '"><input type="' . $field['field_type'] . '" name="' . $field['field_name'] . '" value="' . $field['field_value'] . '" id="' . $field['field_id'] . '" class="' . $field['field_class'] . '" placeholder="' . $field['field_placeholder'] . '"' . $f_req . '/>   ' . $field['field_label'] . $star_req . '</label>';
                    $html .= '</div>';
                } else if ($field['field_type'] == 'datepicker') {
                    if ($field['field_class']) {
                        $class = $field['field_class'] . ' form-datepicker';
                    } else {
                        $class = 'form-datepicker';
                    }
                    $html .= '<div' . (($field['field_div_class']) ? ' class="' . $field['field_div_class'] . '"' : '') . '>';
                    $html .= '<label class="control-label" for="' . $field['field_id'] . '">' . $field['field_label'] . $star_req . '</label>
                        <div class="input-group">
                            <input type="text" name="' . $field['field_name'] . '" value="' . $field['field_value'] . '" id="' . $field['field_id'] . '" class="' . $class . '" placeholder="' . $field['field_placeholder'] . '"' . $f_req . '/>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>';
                    $html .= '</div>';
                } else if ($field['field_type'] == 'timepicker') {
                    if ($field['field_class']) {
                        $class = $field['field_class'] . ' timepicker';
                    } else {
                        $class = 'timepicker';
                    }
                    $html .= '<div' . (($field['field_div_class']) ? ' class="' . $field['field_div_class'] . '"' : '') . '>';
                    $html .= '<label class="control-label" for="' . $field['field_id'] . '">' . $field['field_label'] . $star_req . '</label>
                        <div class="input-group bootstrap-timepicker timepicker">
                            <input type="text" name="' . $field['field_name'] . '" value="' . $field['field_value'] . '" id="' . $field['field_id'] . '" class="' . $class . '" placeholder="' . $field['field_placeholder'] . '"' . $f_req . '/>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        </div>';
                    $html .= '</div>';
                } else if ($field['field_type'] == 'selectbox') {
                    $opt_html = '';
                    if ($field['sel_option_val']) {
                        $opt_arr = explode(",", str_replace(' ', '', $field['sel_option_val']));
                        foreach ($opt_arr as $opt) {
                            list($val, $show) = explode("=>", $opt);
                            $opt_html .= '<option value="' . trim($val) . '">' . trim($show) . '</option>';
                        }
                    }
                    ($field['field_placeholder']) ? $placehol = '<option value="">' . $field['field_placeholder'] . '</option>' : $placehol = '';
                    $html .= '<div' . (($field['field_div_class']) ? ' class="' . $field['field_div_class'] . '"' : '') . '>';
                    $html .= '<label class="control-label" for="' . $field['field_id'] . '">' . $field['field_label'] . $star_req . '</label>
                                <select id="' . $field['field_id'] . '" name="' . $field['field_name'] . '" class="' . $field['field_class'] . '"' . $f_req . '>
                                    ' . $placehol . '
                                    ' . $opt_html . '
                                </select>';
                    $html .= '</div>';
                } else if ($field['field_type'] == 'textarea') {
                    $length_att = '';
                    if ($field['sel_option_val']) {
                        if ($field['sel_option_val']) {
                            $opt_arr = explode(",", str_replace(' ', '', $field['sel_option_val']));
                            foreach ($opt_arr as $opt) {
                                list($maxlengthnum, $minlengthnum) = explode("=>", $opt);
                                if (is_numeric($maxlengthnum) && $maxlengthnum > 0) {
                                    $length_att .= ' maxlength="' . $maxlengthnum . '"';
                                }
                                if (is_numeric($minlengthnum) && $minlengthnum > 0) {
                                    $length_att .= ' minlength="' . $minlengthnum . '"';
                                }
                                break;
                            }
                        }
                    }
                    $html .= '<div' . (($field['field_div_class']) ? ' class="' . $field['field_div_class'] . '"' : '') . '>';
                    $html .= '<label class="control-label" for="' . $field['field_id'] . '">' . $field['field_label'] . $star_req . '</label>
                        <div class="controls">
                            <textarea name="' . $field['field_name'] . '" id="' . $field['field_id'] . '" class="' . $field['field_class'] . '" placeholder="' . $field['field_placeholder'] . '"' . $f_req . $length_att . ' rows="4">' . $field['field_value'] . '</textarea>
                        </div>';
                    $html .= '</div>';
                } else if ($field['field_type'] == 'label') {
                    $html .= '<div' . (($field['field_div_class']) ? ' class="' . $field['field_div_class'] . '"' : '') . '>';
                    $html .= '<label class="' . $field['field_class'] . '" id="' . $field['field_id'] . '" name="' . $field['field_name'] . '">' . $field['field_label'] . $star_req . '</label><br>';
                    $html .= '</div>';
                }
            }
        }
        echo $html;
        ?>
        <br><br>
        <div class="form-actions">
            <?php
            $data = array(
                'name' => 'submit',
                'id' => 'submit',
                'class' => 'btn btn-lg btn-primary',
                'value' => $this->lang->line('btn_save'),
            );
            echo form_submit($data);
            ?> 
            <a class="btn btn-lg btn-default" href="<?php echo $this->csz_referrer->getIndex('admin_form_view'); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>
