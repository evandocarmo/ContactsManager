<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
    <head>
        <?php include_once(APPPATH . 'views/includes/head.php'); ?>
    </head>
    <body>
        <div class="container">
            <div class="container-inner">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody><tr id="filter-mobile"><td><input type="text" name="mobile-search" /></td></tr>
                            <?php foreach ($foreigner as $id => $row): ?>
                            <tr>
                                <td>
                                    <?php print $row->for_name; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/footer.php'); ?>
    </body>
</html>