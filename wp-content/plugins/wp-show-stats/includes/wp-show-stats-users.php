<?php

function wp_show_stats_users() {

    global $wpdb;
    global $wp_roles;

    // get role wise users
    $usersCount = count_users();

    // get total users count
    $totalUsers = count(get_users());

    // Get years of registered users
    $years = $wpdb->get_results("SELECT YEAR(user_registered) AS year FROM " . $wpdb->prefix . "users GROUP BY year DESC");

    // find year wise and month wise comments
    foreach($years as $k => $year){

        // year wise
        $yearWiseUsers = $wpdb->get_results("
            SELECT YEAR(user_registered) as users_year, COUNT(ID) as users_count
                FROM " . $wpdb->prefix . "users
                WHERE YEAR(user_registered) =  '" . $year->year . "'
                GROUP BY users_year
                ORDER BY user_registered ASC"
        );
        if(!empty($yearWiseUsers[0]->users_year)){
            $yearWiseArray[$yearWiseUsers[0]->users_year] = $yearWiseUsers[0]->users_count;
        }

        // month wise
        $monthWiseUsers = $wpdb->get_results("
            SELECT MONTH(user_registered) as users_month, COUNT(ID) as users_count
                FROM " . $wpdb->prefix . "users
                WHERE YEAR(user_registered) =  '" . $year->year . "'
                GROUP BY users_month
                ORDER BY user_registered ASC"
            );

        foreach($monthWiseUsers as $mk => $usr){
            $monthWiseArray[$year->year][$usr->users_month] = $usr->users_count;
        }
    }
    // make the string of month wise comments according to chart's requirements
   foreach($monthWiseArray as $y => $arr){
       $test_arr = array();
       for($i = 1; $i<=12; $i++){
           $test_arr[$i] = isset($arr[$i]) ? $arr[$i] : 0;
       }
       $monthsArray[$y] = implode(",", $test_arr);
   }

   // Custom datewise
   $datewiseUser = array();
   $from_date = date('Y-m-d',strtotime('-1 month'));
   $to_date = date('Y-m-d');
   if(isset($_POST['submit']) && $_POST['submit'] == 'Filter'){
      if( strlen($_POST['date_from']) > 0 ) {
        $from_date = date('Y-m-d',strtotime($_POST['date_from']));
      }
      if( strlen($_POST['date_to']) > 0 ){
       $to_date = date('Y-m-d',strtotime($_POST['date_to']));
      }
   }
   $customDateWiseUsers = $wpdb->get_results("
       SELECT DATE(user_registered) as users_date, COUNT(ID) as users_count
           FROM " . $wpdb->prefix . "users
           WHERE DATE(user_registered) >=  DATE('".$from_date."') AND DATE(user_registered) <=  DATE('".$to_date."')
           GROUP BY users_date
           ORDER BY user_registered ASC"
       );

   foreach($customDateWiseUsers as $dk => $usr){
       $datewiseUser[date('F - Y',strtotime($usr->users_date))][date('j',strtotime($usr->users_date))] = $usr->users_count;
   }

   $datewiseUserData = array();
   foreach ($datewiseUser as $key => $value) {
     $temp = array();
     for ($i=1; $i <= 31; $i++) {
       $temp[$key][$i] = (isset($value[$i]))?$value[$i]:0;
     }
     $datewiseUserData[$key] = implode(",", $temp[$key]);
   }
  ?>

    <div class="wrap">
        <h2>WP Show Stats - Users Statistics</h2>
        <div class="stat-charts-main">
            <div class="chartBox">
                <div id="rolewiseChart"></div>
            </div>
            <div class="chartBox">
                <div id="byYearChart"></div>
            </div>
            <div class="chartBoxLarge">
                <div id="monthWiseChart"></div>
            </div>
            <div class="chartBoxLarge">
                <div class="wpss-date-wise-user">
                  <form action="<?php site_url('wp-admin/admin.php?page=wp_show_stats_users'); ?>" method="post">
                  <ul>
                      <li><input name="date_from" type="text" id="date_from" value="<?php echo (isset($_POST['date_from']) && strlen($_POST['date_from']) > 0)?date('m/d/Y', strtotime($_POST['date_from'])):''; ?>" class="regular-text datepicker" placeholder="From"></li>
                      <li><input name="date_to" type="text" id="date_to" value="<?php echo (isset($_POST['date_to']) && strlen($_POST['date_to']) > 0)?date('m/d/Y', strtotime($_POST['date_to'])):''; ?>" class="regular-text datepicker" placeholder="To"></li>
                      <li><input name="submit" type="submit" class="button button-primary" value="Filter"></li>
                  </ul>
                </form>
                </div>
                <div id="dateWiseChart"></div>
            </div>
        </div>
    </div>

    <?php include_once('wp-show-stats-sidebar.php'); ?>

    <script type="text/javascript">
            jQuery(document).ready(function(){
              jQuery('.datepicker').datepicker({dateFormat : "mm/dd/yy"});
            });
            google.load("visualization", "1", {packages: ["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {

                // rolewise users count
                <?php if($totalUsers > 0): ?>
                    var rolewisedata = google.visualization.arrayToDataTable([
                        ["Role", "Number of users", {role: "style"}],
                        <?php $i=0; foreach ($usersCount['avail_roles'] as $role => $count): $i++; ?>
                            ["<?php echo ucfirst($role) ?>", <?php echo $count; ?>, "<?php echo $i%2==0 ? "#00ff00" : "0000ff"; ?>"],
                        <?php endforeach; ?>
                    ]);
                    var rolewiseview = new google.visualization.DataView(rolewisedata);
                    rolewiseview.setColumns([0, 1, 2]);
                    var rolewiseoptions = {
                        title: "Role wise users (Total users: <?php echo $totalUsers; ?>)",
                        bar: {groupWidth: "95%"},
                        legend: {position: "none"},
                    };
                    var rolewisechart = new google.visualization.ColumnChart(document.getElementById("rolewiseChart"));
                    rolewisechart.draw(rolewiseview, rolewiseoptions);
                <?php else: ?>
                    document.getElementById('rolewiseChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'Rolewise Users Stats' because there are no users found.</span>";
                <?php endif; ?>


                // year wise user registration
                <?php if(count($yearWiseArray) > 0): ?>
                    var yearwisedata = google.visualization.arrayToDataTable([
                        ["Year", "Number of users registered", {role: "style"}],
                        <?php $i=0; foreach($yearWiseArray as $k => $val): $i++; ?>
                            ["<?php echo $k; ?>", <?php echo $val; ?>, "<?php echo $i%2==0 ? "#00ff00" : "0000ff"; ?>"],
                        <?php endforeach; ?>
                    ]);
                    var yearwiseview = new google.visualization.DataView(yearwisedata);
                    yearwiseview.setColumns([0, 1,2]);
                    var yearwiseoptions = {
                        title: "Users registration by year (Total: <?php echo $totalUsers; ?>)",
                        bar: {groupWidth: "70%"},
                        legend: {position: "none"},
                    };
                    var yearwiseChart = new google.visualization.ColumnChart(document.getElementById("byYearChart"));
                    yearwiseChart.draw(yearwiseview, yearwiseoptions);
                <?php else: ?>
                    document.getElementById('byYearChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'User Registration By Year Stats' because there are no users found.</span>";
                <?php endif; ?>

                // monthwise user registration chart
                <?php if(count($monthsArray) > 0): ?>
                    var monthwisedata = google.visualization.arrayToDataTable([
                        ['Month', 'Jan','Feb','Mar','Apr','May','Jun','July','Aug','Sept','Oct','Nov','Dec', { role: 'annotation' } ],
                        <?php foreach($monthsArray as $k => $data): ?>
                            ['<?php echo $k; ?>',<?php echo $data; ?>,''],
                        <?php endforeach; ?>
                    ]);

                    var monthwiseoptions = {
                        width: 1015,
                        height: 500,
                        title: "Month wise user registration",
                        legend: { position: 'top', maxLines: 3 },
                        bar: { groupWidth: '55%' },
                        isStacked: true,
                      };
                    var monthwiseview = new google.visualization.DataView(monthwisedata);
                    monthwiseview.setColumns([0,1,2,3,4,5,6,7,8,9,10,11,12]);
                    var monthwiseChart = new google.visualization.ColumnChart(document.getElementById("monthWiseChart"));
                    monthwiseChart.draw(monthwiseview, monthwiseoptions);
                <?php else: ?>
                    document.getElementById('monthWiseChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'User Registration By Months Stats' because there are no users found.</span>";
                <?php endif; ?>

                // monthwise user registration chart
                <?php if(count($datewiseUser) > 0): ?>
                    var dateWisedata = google.visualization.arrayToDataTable([['MONTH',  {'type': 'string', 'role': 'tooltip', 'p': {'html': true}}, '1st','2nd','3rd','4th','5th','6th','7th','8th','9th','10th','11th','12th','13th','14th','15th','16th','17th','18th','19th','20tth','21st','22nd','23rd','24th','25th','26th','27th','28th','29th','30th','31st' ],
                      <?php foreach ($datewiseUserData as $key => $value) {
                            echo "['".$key."','',".$value."],";
                      } ?>
                    ]);

                    var dateWiseOption = {
                      width: 1015,
                      tooltip: { isHtml: true },
                      height: 500,
                      title: "Date wise user registration",
                      legend: { position: 'none' },
                      bar: { groupWidth: '55%' },
                      isStacked: true,
                      tooltip: { trigger: 'focus' }
                    };
                    var dateWiseview = new google.visualization.DataView(dateWisedata);
                    var datewiseChart = new google.visualization.ColumnChart(document.getElementById("dateWiseChart"));
                    datewiseChart.draw(dateWiseview, dateWiseOption);
                <?php else: ?>
                    document.getElementById('dateWiseChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'User Registration By Months Stats' because there are no users found.</span>";
                <?php endif; ?>
            }
        </script>

<?php } ?>
