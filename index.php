<?php

/**
 * @author Raja Azian
 * @email rajaazian08@gmail.com
 * @create date 2023-07-12 12:01:45
 * @modify date 2023-07-12 18:39:35
 * @license GPLv3
 * @desc [description]
 */

defined('INDEX_AUTH') or die('Direct access is not allowed!');

// start the session
require SB . 'admin/default/session.inc.php';
require SB . 'admin/default/session_check.inc.php';

require SIMBIO . 'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO . 'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO . 'simbio_DB/simbio_dbop.inc.php';

function httpQuery($query = [])
{
    return http_build_query(array_unique(array_merge($_GET, $query)));
}


$stmt = \SLiMS\DB::getInstance()->prepare("SELECT * FROM search_recommendations_settings WHERE id = :id");
$stmt->execute(['id' => 1]);
if ($stmt->rowCount() > 0) {
    $data = $stmt->fetchObject();

    $resUri = $data->rest_uri;
    $count = $data->count;
    $token = $data->token;
}

if (isset($_POST['saveData'])) {

    $resUri = $_POST['rest_uri'];
    $count = $_POST['count'];
    $token = $_POST['token'];

    if ($stmt->rowCount() > 0) {
        $stmt = \SLiMS\DB::getInstance()->prepare("UPDATE search_recommendations_settings SET rest_uri = :rest_uri, token = :token, count = :count WHERE id = :id");
        $stmt->execute([
            'rest_uri' => $resUri,
            'count' => $count,
            'token' => $token,
            'id' => 1
        ]);

        toastr('Konfigurasi berhasil disimpan')->success();
        exit;
    } else {
        $stmt = \SLiMS\DB::getInstance()->prepare("INSERT INTO search_recommendations_settings(rest_uri, token, count) VALUES (:rest_uri, :token, :count)");
        $stmt->execute([
            'rest_uri' => $resUri,
            'count' => $count,
            'token' => $token
        ]);
        toastr('Konfigurasi berhasil disimpan')->success();
        exit;
    }
}
?>
<div class="menuBox">
    <div class="menuBoxInner systemIcon">
        <div class="per_title">
            <h2><?php echo __('Search Recommendations Configs') ?></h2>
        </div>
    </div>
</div>

<?php

$form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'] . '?' . httpQuery(), 'post');
$form->submit_button_attr = 'name="saveData" value="' . __('Save Settings') . '" class="btn btn-default"';

// form table attributes
$form->table_attr = 'id="dataList" class="s-table table"';
$form->table_header_attr = 'class="alterCell font-weight-bold"';
$form->table_content_attr = 'class="alterCell2"';

$form->addTextField(
    'text',
    'rest_uri',
    __('Rest API url'),
    trim($resUri),
    'style="width: 100%;" class="form-control"'
);

$form->addTextField(
    'text',
    'count',
    __('Recommendations count'),
    trim($count),
    'style="width: 100%;" class="form-control"'
);

$form->addTextField(
    'text',
    'token',
    __('Token'),
    trim($token),
    'style="width: 100%;" class="form-control"'
);

// print out the object
echo $form->printOut();

?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info"><?php echo __('In order to make the search recommendations works, please enable and update CSP plugin by put the \'rest_api\' url to the \'Connect Src\' field') ?></div>
        </div>
    </div>
</div>