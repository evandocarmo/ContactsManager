<div class="container" style="width: 500px;">
    <form action="<?php print $this->config->base_url(); ?>perfil/form/<?php print $id; ?>/<?php print (isset($visit->vis_id)) ? $visit->vis_id : ''; ?>" method="post" accept-charset="utf-8" style="margin: 0px;">
        <fieldset>
            <legend>Cadastrar Observa&ccedil;&otilde;es</legend>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on">Data</span>
                    <input id="bootstrap-date" class="span4" type="text" name="date" value="<?php print (isset($visit->vis_date)) ? date("d/m/Y", strtotime($visit->vis_date)) : ""; ?>" style="width: 445px;" />
                </div>
                <div class="input-prepend">
                    <span class="add-on">Publicador</span>
                    <input class="span4" type="text" name="publisher" value="<?php print (isset($visit->vis_publisher)) ? $visit->vis_publisher : ""; ?>" style="width: 407px;" />
                </div>
                <div class="input-prepend">
                    <textarea class="form-control" rows="3" name="description" placeholder="Observações" style="width: 485px; resize: vertical;">
                        <?php print (isset($visit->vis_description)) ? $visit->vis_description : ""; ?>
                    </textarea>
                </div>
            </div>
        </fieldset>
        <div class="form-actions" style="margin: 0px;">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
        <input type="hidden" name="foreigner" value="<?php print $id; ?>" />
    </form>
</div>