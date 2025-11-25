@extends('layouts.admin', [
  'dash' => '',
  'examinees' => 'active',
  'quiz' => '',
  'users' => '',
  'questions' => '',
  'sett' => ''
])
@section('content')
@php
    $average=0;$overallScore=0;$perfectScore=0;
    $score = array();
    $x =0;$max=0;
    $semi_result = json_decode($result,true);
	if(!empty($semi_result)){
		$semi_result =$semi_result[0];
		$semi_result =json_decode($semi_result['score'],true);
		foreach ($semi_result as $key => $value) {$max +=$value['max'];}
		foreach ($semi_result as $key => $value) {
		  $score[$x] = $value['score'] / $max*100 ;
		  $x++;
		}
	}

@endphp
<div id="situationModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button class="btn btn-default btn-sm pull-right" id="btnprint"><span class="glyphicon glyphicon-print" title="Print"></span></button>
        <button class="btn btn-default btn-sm pull-right mr-3" onclick="exportPDF('{{route('situation.pdf')}}',{{$user->id}})"><span class="glyphicon glyphicon-save-file" title="Save as PDF"></span></button>
      </div>
        <div class="modal-body" id="printJS-form">
          <pre id="pname" style="display:none;">   Applicant Name: <b>{{ucwords($user->name)}}</b></pre>
          <center><h4 class="modal-title">Reading Comprehension</h4></center><br>
          <ol>
            @foreach ( $essay as $es )
            <li>
				      <p>{{$es->situation}}</p>
              <p><b>Answer:</b></p>
              <div> <pre style="white-space:pre-wrap">{{$es->answer}}</pre></div>
            </li>
            @endforeach
          </ol>
        <br>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<div class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-body" id="printResult">
          <p>Applicant Name: <b>{{ucwords($user->name)}}</b></p>
          <p>Examinee No : {{hash('crc32b',$user->id)}}</p>
          <h3 style="text-align:center">Examination Results</h3>
		 @if(!empty($semi_result))
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Subject</th>
                <th scope="col">Score</th>
                <th scope="col">Over</th>
                <th scope="col">Percentage</th>
                <th scope="col">Status</th>
              </tr>
            <tbody>
              @foreach($semi_result as $subject=>$exam)
              @php
                $overallScore+= $exam['score'];
                $perfectScore+=$exam['max'];
                $average = round($overallScore/$perfectScore*100,2);
                $finalStats = ($average>=75)?'Passed':'Failed';
                $percentage = round($exam['score']/$exam['max']*100,2);
                $status =($percentage>=75)?'Passed':'Failed';
              @endphp
              <tr>
                <th scope="row">{{$subject}}</th>
                <td>{{$exam['score']}}</td>
                <td>{{$exam['max']}}</td>
                <td>{{$percentage.' %'}}</td>
                <td>{{$status}}</td>
              </tr>
              @endforeach
              <tr>
                <th></th>
                <td></td>
                <th scope="row">Average</th>
                <td><b>{{$average.' %'}}</b></td>
                <td><b>{{$finalStats}}</b></td>
              </tr>
            </tbody>
          </table>
		  @else
			  <center><h2>No Result</h2></center>
		  @endif
        </div>
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <select id='selUser' style='width: 200px;'>
    @if ($users)
    @foreach ($users as $key => $user_list)
      <option value='{{$user_list->id}}'>{{$user_list->name}}</option>
    @endforeach
  @endif
  </select>
  <br><br><br>
  <div class="row " id="printResult">
    <div class="col-md-1"></div>
    <div class="col-md-10 result-box"><br>
      <button class="btn btn-default btn-sm pull-right " id="btnprintResult"><span class="glyphicon glyphicon-print" title="Print"></span></button>
      <button class="btn btn-default btn-sm pull-right mr-3" onclick="exportPDF('{{route('examresult.pdf')}}',{{$user->id}})" title="Save As PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
      <h2 class="text-center">Examination Results</h2>
      <div class="row">
        <div class="col-md-3">
          <img src="{{asset('/images/vectors/user.png')}}" class="img-responsive img-circle "><br>
          <p style="font-size: 1.2rem;color:rgb(156, 151, 151)">Examinee No : {{$user->id}}</p>
          <h4><strong>{{ucwords($user->name)}}</strong></h4>
          <p><strong>Applied</strong>:&nbsp;<span class="label label-primary">{{$user->applied_position}}</span></p>
        </div>
        <div class="col-md-6">
          <br>
		   @if(!empty($semi_result))
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Subject</th>
                <th scope="col">Score</th>
                <th scope="col">Over</th>
                <th scope="col">Percentage</th>
                <th scope="col">Status</th>
              </tr>
            <tbody>
              @foreach($semi_result as $subject=>$exam)
              @php
                $overallScore+= $exam['score'];
                $perfectScore+=$exam['max'];
                $average = round($overallScore/$perfectScore*100,2);
                $finalStats = ($average>=75)?'Passed':'Failed';
                $percentage = round($exam['score']/$exam['max']*100,2);
                $status =($percentage>=75)?'Passed':'Failed';

              @endphp
              <tr>
                <th scope="row">{{$subject}}</th>
                <td>{{$exam['score']}}</td>
                <td>{{$exam['max']}}</td>
                <td>{{$percentage.' %'}}</td>
                <td>{{$status}}</td>
              </tr>
              @endforeach
              <tr>
                <th></th>
                <td></td>
                <th scope="row">Average</th>
                <td><b>{{$average.' %'}}</b></td>
                <td><b>{{$finalStats}}</b></td>
              </tr>
            </tbody>
          </table>
		  @else
			  <center><h2>No Result</h2></center>
		  @endif
          <center><button class="btn btn-warning" data-toggle="modal" data-target="#situationModal">Reading Comprehension Answers.</button></center>
        </div>

        <div class="col-md-3 text-center " >
		@if(!empty($semi_result))
          <br>
          <h4>Overall Rating</h4>
          <canvas id="myChart"></canvas>
          <h4><span class="label label-{{$finalStats=='Passed'?'success':'danger'}}">{{$finalStats}}</span></h4>
		 @endif
        </div>
      </div>
    </div>
    <div class="col-md-1"></div>
  </div>

</div>
<script>

var data = <?php echo json_encode($score); ?>;

var ctx = document.getElementById("myChart").getContext('2d');
var chart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Green", "Blue", "Gray", "Purple", "Yellow", "Red", "Black"],
    datasets: [{
      backgroundColor: [
        "#2ecc71",
        "#3498db",
        "#95a5a6",
        "#9b59b6",
        "#f1c40f",
        "#e74c3c",
        "#34495e"
      ],
      data: data,
      hoverOffset: 4,
    }]
  },
  options: {
    cutoutPercentage: 60,
    aspectRatio:1.3,
    legend: {
      display: false
    },
    elements: {
      center: {
        text: <?php echo json_encode($average); ?> + '%',
        color: '#FF6384', // Default is #000000
        fontStyle: 'Arial', // Default is Arial
        sidePadding: 20, // Default is 20 (as a percentage)
        minFontSize: 15, // Default is 20 (in px), set to false and text will not wrap.
        lineHeight: 25 // Default is 25 (in px), used for when text wraps
      }
    }
  }
});
Chart.pluginService.register({
      beforeDraw: function(chart) {
        if (chart.config.options.elements.center) {
          // Get ctx from string
          var ctx = chart.chart.ctx;

          // Get options from the center object in options
          var centerConfig = chart.config.options.elements.center;
          var fontStyle = centerConfig.fontStyle || 'Arial';
          var txt = centerConfig.text;
          var color = centerConfig.color || '#000';
          var maxFontSize = centerConfig.maxFontSize || 75;
          var sidePadding = centerConfig.sidePadding || 20;
          var sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 2)
          // Start with a base font of 30px
          ctx.font = "30px " + fontStyle;

          // Get the width of the string and also the width of the element minus 10 to give it 5px side padding
          var stringWidth = ctx.measureText(txt).width;
          var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

          // Find out how much the font can grow in width.
          var widthRatio = elementWidth / stringWidth;
          var newFontSize = Math.floor(30 * widthRatio);
          var elementHeight = (chart.innerRadius * 2);

          // Pick a new font size so it will not be larger than the height of label.
          var fontSizeToUse = Math.min(newFontSize, elementHeight, maxFontSize);
          var minFontSize = centerConfig.minFontSize;
          var lineHeight = centerConfig.lineHeight || 25;
          var wrapText = false;

          if (minFontSize === undefined) {
            minFontSize = 12;
          }

          if (minFontSize && fontSizeToUse < minFontSize) {
            fontSizeToUse = minFontSize;
            wrapText = true;
          }

          // Set font settings to draw it correctly.
          ctx.textAlign = 'center';
          ctx.textBaseline = 'middle';
          var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
          var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
          ctx.font = fontSizeToUse + "px " + fontStyle;
          ctx.fillStyle = color;

          if (!wrapText) {
            ctx.fillText(txt, centerX, centerY);
            return;
          }

          var words = txt.split(' ');
          var line = '';
          var lines = [];

          // Break words up into multiple lines if necessary
          for (var n = 0; n < words.length; n++) {
            var testLine = line + words[n] + ' ';
            var metrics = ctx.measureText(testLine);
            var testWidth = metrics.width;
            if (testWidth > elementWidth && n > 0) {
              lines.push(line);
              line = words[n] + ' ';
            } else {
              line = testLine;
            }
          }

          // Move the center up depending on line height and number of lines
          centerY -= (lines.length / 2) * lineHeight;

          for (var n = 0; n < lines.length; n++) {
            ctx.fillText(lines[n], centerX, centerY);
            centerY += lineHeight;
          }
          //Draw text in center
          ctx.fillText(line, centerX, centerY);
        }
      }
    });

</script>
<script>
  function exportPDF(url,id,view){
        $.ajax({
          type: "GET",
          url: url,
          contentType: false,
          data:{'id':id},
          success: function(data){
            console.log('PDF Downloaded');

          },
          error: function (xhr, status, error) {
          }
        });
    }
  $(function () {
    $( document ).ready(function() {
       $("#selUser").select2();
       $("#selUser").on('change', function (e) {
         var id = $("#selUser").val();
         var url = "{{ route('exam.result', ":id") }}";
         url = url.replace(':id', id);

        $.ajax({
          type: "GET",
          url:url,
          contentType: false,
          success: function(data){
            $(".content").html(data);
            $("#selUser").val(id);
            window.history.pushState("", "", url);
          },
          error: function (xhr, status, error) {
            alert(xhr.responseText);
          }
        });
      });

       $("#btnprint").on('click',function(){
          $("#pname").css('display','block');
          printJS({printable: 'printJS-form', type: 'html', css: 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'});
          $("#pname").css('display','none');
      });
      $("#btnprintResult").on('click',function(){
          printJS({printable: 'printResult', type: 'html', css: 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'});
      });
    });
  });
</script>
@endsection

