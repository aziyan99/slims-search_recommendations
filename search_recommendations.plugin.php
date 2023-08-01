<?php

/**
 * Plugin Name: Search Recommendations
 * Plugin URI: https://aziyan99.github.io
 * Description: OPAC search results with recommendations
 * Version: 1.0.0
 * Author: Raja Azian (rajaazian08@gmail.com)
 * Author URI: https://aziyan99.github.io
 */

use SLiMS\Plugins;

$plugins = Plugins::getInstance();

$plugins->registerMenu('system', __('Search Recommendations'), __DIR__ . '/index.php');

$plugins->register(Plugins::CONTENT_AFTER_LOAD, function () {
    $stmt = \SLiMS\DB::getInstance()->prepare("SELECT * FROM search_recommendations_settings WHERE id = :id");
    $stmt->execute(['id' => 1]);
    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetchObject();

        $resUri = $data->rest_uri;
        $count = $data->count;
        $token = $data->token; ?>

        <script>
            $(document).ready(function() {

                const fetchRecommendations = async function(keywords) {
                    return await fetch(`<?php echo $resUri ?>?keywords=${keywords}&count=<?php echo $count ?>`);
                }

                const truncate = function(str, n) {
                    return (str.length > n) ? str.substring(0, n).concat('...') : str;
                };

                const keywords = new URLSearchParams(window.location.search).get('keywords');
                if (keywords !== null) {

                    const filterForm = $('#search-filter');

                    fetchRecommendations(keywords).then(response => response.json()).then((data) => {

                        let recommendationsResults = `
                        <div class="my-3">
                            <h4>Recommendations</h4>`;

                        data.forEach(function(item) {
                            recommendationsResults += `
                            <div class="my-2">
                                <a href="/index.php?keywords=${item.title}&search=search" class="text-sm block py-0 my-0" target="_blank">
                                    ${truncate(item.title, 20)}
                                    <i class="fas fa-external-link-square-alt"></i>
                                </a>
                            </div>`;
                        });

                        recommendationsResults += `</div>`;
                        filterForm.after(recommendationsResults);
                    });

                }
            });
        </script>
    <?php } ?>
<?php }); ?>