<?php
/**
 * Callback for apps/boiler-plate-app/data.
 */
function _govcon_app_data($machine_name, $app_route, $params, $args) {
  $return = array();
  $query = new EntityFieldQuery();
  // pull in all our banners that have been uploaded to the site
  $result = $query->entityCondition('entity_type', 'node')
  ->entityCondition('bundle', 'govcon_banner')
  ->propertyCondition('status', 1)
  ->propertyOrderBy('changed', 'DESC')
  ->execute();
  // flip the results if it found them
  if (isset($result['node'])) {
    foreach ($result['node'] as $item) {
      $node = node_load($item->nid);
      // resolve the URL for the image
      $return[$node->nid]->image = file_create_url($node->field_image['und'][0]['uri']);
      $return[$node->nid]->title = $node->title;
      $return[$node->nid]->text = $node->field_text['und'][0]['value'];
      $return[$node->nid]->link = $node->field_url['und'][0]['url'];
    }
  }
  return array(
    'status' => 200,
    'data' => $return
  );
}
