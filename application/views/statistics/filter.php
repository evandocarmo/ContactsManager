<form id="search" action="<?php print $this->config->base_url(); ?>statistics/foreigners" method="get">
    <table>
        <colgroup>
            <col span="1" style="width: 70px;" />
            <col span="1" style="width: 223px;" />
            <col span="1" style="width: 135px;" />
            <col span="1" style="width: 80px;" />
            <col span="1" style="width: 250px;" />
            <col span="1" style="width: 142px;" />
        </colgroup>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Country</th>
                <th>Status</th>
                <th>Region</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <tr id="filter">
                <td><input type="text" name="for_id" value="<?php print ($this->input->get('for_id')) ? $this->input->get('for_id') : ""; ?>" /></td>
                <td><input type="text" name="for_name" value="<?php print ($this->input->get('for_name')) ? $this->input->get('for_name') : ""; ?>" /></td>
                <td>
                    <select name="for_nationality">
                        <option value="ALL" <?php if ("ALL" == $this->input->get('for_nationality')): ?>selected="selected"<?php endif; ?>>All</option>
                        <option value="0" <?php if ('0' === $this->input->get('for_nationality')): ?>selected="selected"<?php endif; ?>>Uninformed</option>
                        <?php foreach ($country as $id => $value): ?>
                            <option value="<?php print $value->id; ?>" <?php if ($value->id == $this->input->get('for_nationality')): ?>selected="selected"<?php endif; ?>><?php print $value->name; ?> (<?php print $value->number; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="sta_id">
                        <option value="ALL" <?php if ("ALL" == $this->input->get('sta_id')): ?>selected="selected"<?php endif; ?>>All</option>
                        <?php foreach ($status as $id => $value): ?>
                            <option value="<?php print $value->sta_id; ?>" <?php if ($value->sta_id == $this->input->get('sta_id')): ?>selected="selected"<?php endif; ?>><?php print $value->sta_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="cat_id">
                        <option value="ALL" <?php if ("ALL" == $this->input->get('cat_id')): ?>selected="selected"<?php endif; ?>>All</option>
                        <?php foreach ($category as $id => $value): ?>
                            <option value="<?php print $value->cat_id; ?>" <?php if ($value->cat_id == $this->input->get('cat_id')): ?>selected="selected"<?php endif; ?>><?php print $value->cat_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <button type="submit" class="bottom">Submit</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>