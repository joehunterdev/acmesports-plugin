# Acme Sports Challenge

 A simple plugin to display a list of NFL Teams

## Version 1.2.0:

### Features:
 - Simple boiler plate structure
 - Call to api to retrieve data `get_teams_list_array()` and convert to php array
 - Table builder to loop through results and build table  `nfl_teams_table_function()`
 - Enqueue styles using `wp_enqueue_style();` "table" and "page" stylings 
 - Enqueue jquery (plugin datatables) `wp_enqueue_script();` datatables is jquery dependant
 - Admin Page to highlight to client the instructions. IE please use shortcode [nfl_data_teams_table] 
 - Functionality to include required (css/js dependancies) [https://datatables.net/]


## Version 1.5.0
 - Re-Order column data putting id first (Anything else missing ? league position ?)
 - Possibly utilize other endpoint + shortcode [nfl_data_team_table teamid="55"] to create linked page for more stats and information `<a href="team_info/?id=58">See More</a>`
 - Create method/function `get_data($endpoint ='')`  to handle different endpoints.[https://delivery.oddsandstats.co/{$endpoint}]
 - Additional Endpoint Parameter funcionality: `get_table_data($endpoint ='',$start = '', $limit = '', $sortby = '')` 
 - Implement jquery ajax internal endpoint to make it easier for serverside pagination of lots of results

 
## Version 2.5.0
 - Make 1.5.0 versioned parameters available via a custom field inside admin.php?page so admins can easily change the following



 
