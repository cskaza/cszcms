<table x:str BORDER="1">
    <tr>
        <td align="center"><b>No.</b></td>
        <?php
        $i = 1;
        if (!empty($field_rs)) {
            foreach ($field_rs as $field) {
                if ($field['field_type'] != 'button' && $field['field_type'] != 'reset' && $field['field_type'] != 'submit' && $field['field_type'] != 'label') {
                    ?>                            
                    <td align="center"><b><?php echo $field['field_label'] ?></b></td>
                    <?php
                    $i++;
                }
            }
        }
        ?>
    </tr>
    <?php if ($post_rs === FALSE) { ?>
        <tr>
            <td colspan="<?php echo $i ?>" align="center"><b><?php echo $this->lang->line('data_notfound') ?></b></td>
        </tr>                           
    <?php } else { ?>
        <?php
        $c = 1;
        foreach ($post_rs as $u) {
            echo '<tr>';
            echo '<td>' . $c . '</td>';
            if (!empty($field_rs)) {
                foreach ($field_rs as $field) {
                    if ($field['field_type'] != 'button' && $field['field_type'] != 'reset' && $field['field_type'] != 'submit' && $field['field_type'] != 'label' && $field['field_type'] != 'file') { ?>
                        <td><?php echo ($u[$field['field_name']] ? $u[$field['field_name']] : '-') ?></td>
                    <?php }
                    if ($field['field_type'] == 'file') { ?>
                        <td><?php echo ($u[$field['field_name']] ? base_url() . "photo/forms/" . $this->Csz_model->cleanEmailFormat($form_name) . '/' . $this->Csz_model->cleanEmailFormat($field['field_name']) . '/' .$u[$field['field_name']] : '-') ?></td>
                    <?php } ?> 
                <?php
                }
            }
            echo '</tr>';
            $c++;
        } ?>
<?php } ?>
</table>