
            <footer id="footer">
                {!!$copyright_footer_1!!}
                <center>{{$copyright_footer_2}}</center>
            </footer>

        </section>

        <!-- Javascript Libraries -->
        <script src="{{ asset($assets) }}/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="{{ asset($assets) }}/endors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bootgrid/jquery.bootgrid.updated.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/moment/min/moment.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/salvattore/dist/salvattore.min.js"></script>

        <script src="{{ asset($assets) }}/vendors/bower_components/flot/jquery.flot.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/flot/jquery.flot.resize.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>
        <script src="{{ asset($assets) }}/vendors/sparklines/jquery.sparkline.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
        <script src="{{ asset($assets) }}/js/flot-charts/curved-line-chart.js"></script>
        <script src="{{ asset($assets) }}/js/flot-charts/line-chart.js"></script>

        <!-- More -->
        <script src="{{ asset($assets) }}/vendors/summernote/dist/summernote-updated.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/autosize/dist/autosize.min.js"></script>
        <!-- Modals -->
        <script src="{{ asset($assets) }}/modals/js/modalMedia.js"></script>

        <script src="{{ asset($assets) }}/typeahead/bloodhound.js"></script>
        <script src="{{ asset($assets) }}/typeahead/typeahead.bundle.js"></script>
        <script src="{{ asset($assets) }}/typeahead/typeahead.jquery.js"></script>

        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
        <script src="{{ asset($assets) }}/vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

        <!-- Javascript Libraries -->        
        <script src="{{ asset($assets) }}/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/nouislider/distribute/jquery.nouislider.all.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/typeahead.js/dist/typeahead.bundle.min.js"></script>
        
        <script src="{{ asset($assets) }}/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/fileinput/fileinput.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/input-mask/input-mask.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/farbtastic/farbtastic.min.js"></script>

        <script src="{{ asset($assets) }}/js/charts.js"></script>

        <script src="{{ asset($assets) }}/js/functions.js"></script>
        <script src="{{ asset($assets) }}/js/actions.js"></script>

        <!--<script src="{{ asset($assets) }}/js/demo.js"></script>-->
        <script src="{{ asset($assets) }}/custom/custom.js"></script>
        
        <!-- Data Table -->
        <script type="text/javascript">
            $(document).ready(function(){

                //Basic Example
                $("#data-table-basic").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                });
                
                //Selection
                $("#data-table-selection").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    selection: true,
                    multiSelect: true,
                    rowSelect: true,
                    keepSelection: true
                });
                
                //Command Buttons
                $("#data-table-command").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    formatters: {
                        "commands": function(column, row) {  
                            return "<a onclick=\"actionSingleEdit(\'edit,"+ row.id +"\');\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></a> " + 
                                "<a onclick=\"actionSingleValid(\'delete,"+ row.id +"\');\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></a>";
                        }
                    },
                    selection: true,
                    multiSelect: true,
                    rowSelect: true,
                    keepSelection: true
                });

                //Command Buttons
                $("#data-table-command-manage").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    formatters: {
                        "commands": function(column, row) {  
                            return "<a onclick=\"actionSingleValid(\'manage,"+ row.id +"\');\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-receipt zmdi-hc-fwt\"></span></a> ";
                        }
                    },
                    selection: true,
                    multiSelect: true,
                    rowSelect: true,
                    keepSelection: true
                });
            });
        </script>

        <script type="text/javascript">

            //Manage Bulk Action
            function actionBulk(argument) {
                
                //Set Counter Variable and Array
                var i = 0, sThisVal = {};

                //Set Data
                $('input[name=select-inputs]:checked').each(function () {                    
                    if($(this).val() != 'all'){

                        sThisVal[i] = $(this).val();
                        i++;
                    }
                }); 

                //Get Data In Json Format  
                var selectedData = JSON.stringify(sThisVal);

                //base URL as found in config-base URL
                <?php $routeURL = strtolower($routeURL); ?>
                var base_url = "{{url($routeURL)}}";
                //Action and Element ID/Name/Data
                var action_id = '/valid/bulk/' + '?action=' + argument + '&inputID=' + selectedData;
                //Url to Action
                var action_url = base_url+action_id;
                window.location.href =action_url;
            }

            //Action Single Edit
            function actionSingleEdit(argument) {
                var dataSelected = argument.split(",");

                //base URL as found in config-base URL
                <?php $routeURL = strtolower($routeURL); ?>
                var base_url = "{{url($routeURL)}}";
                //Action and Element ID/Name/Data
                var action_id = '/edit/' + dataSelected[0] + '?inputID=' + dataSelected[1];
                //Url to Action
                var action_url = base_url+action_id;
                window.location.href =action_url;
            }
            //Action Single Valid
            function actionSingleValid(argument) {
                var dataSelected = argument.split(",");

                //base URL as found in config-base URL
                <?php $routeURL = strtolower($routeURL); ?>
                var base_url = "{{url($routeURL)}}";
                //Action and Element ID/Name/Data
                var action_id = '/valid/' + dataSelected[0] + '?inputID=' + dataSelected[1];
                //Url to Action
                var action_url = base_url+action_id;
                window.location.href =action_url;
            }
        </script>

        <!-- Include Footer -->
        @include("admin/functions/incl_footer")
        <!-- End Include Footer -->

    </body>
  
</html>