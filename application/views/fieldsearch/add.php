<form id="default" action="<?php print $this->config->base_url(); ?>fieldsearch/add" method="post">
    <fieldset>
        <legend>Field Service Information</legend>
        <dl>
            <dt>
                <label for="fie_date">Date</label>
            </dt>
            <dd>
                <input type="text" name="fie_date" />
            </dd>
        </dl>
        <dl>
            <dt>
                <label for="fie_conductor">Conductor</label>
            </dt>
            <dd>
                <input type="text" name="fie_conductor" />
            </dd>
        </dl>
    </fieldset>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>