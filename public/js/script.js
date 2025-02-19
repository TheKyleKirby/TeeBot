$(document).ready(function () {
    $('#scorecard-form').submit(function (e) {
        e.preventDefault();
        let playerName = $('#player_name').val();
    
        $.post("http://localhost/TeeBot/create_scorecard.php", { player_name: playerName }, function (data) {
            console.log("Server response:", data);
    
            if (data.success) {
                alert(data.message); 
                $('#player_name').val(""); 
                displayHolesForm(data.id); 
            } else {
                alert("Error: " + data.message);
            }
        }, "json").fail(function () {
            alert("Failed to connect to the server.");
        });
    });

    // Display 18 holes form
    function displayHolesForm(scorecardId) {
        $('#scorecard-details').removeClass('hidden'); 
        $('#holes-container').empty(); 

        // Generate fields for holes
        for (let i = 1; i <= 18; i++) {
            $('#holes-container').append(`
                <div>
                    <label for="hole-${i}" class="block text-gray-700">Hole ${i}:</label>
                    <input type="number" id="hole-${i}" name="hole_${i}" class="w-full p-3 border border-gray-300 rounded focus:outline-none" min="0" max="10" />
                </div>
            `);
        }

        $('#scores-form').data('scorecardId', scorecardId);
    }

    // Save the scores for the 18 holes
    $('#scores-form').submit(function (e) {
        e.preventDefault();
        let scorecardId = $(this).data('scorecardId');
        let scores = [];

        // Collect all hole scores
        for (let i = 1; i <= 18; i++) {
            let score = $(`#hole-${i}`).val();
            scores.push(score ? score : 0); 
        }

        $.post("http://localhost/TeeBot/save_scores.php", { scorecard_id: scorecardId, scores: scores }, function (data) {
            alert("Scores Saved Successfully!");
            loadScorecards(); 
        }).fail(function () {
            alert("Error saving scores.");
        });
    });

    // Load existing scorecards
    function loadScorecards() {
        $.get("http://localhost/TeeBot/get_scorecards.php", function (data) {
            $('#scorecards-table tbody').html(data);
        }).fail(function () {
            alert("Failed to load scorecards.");
        });
    }

    $(document).on('click', '.view-scorecard', function () {
        let scorecardId = $(this).data('id');
        
        // Load the scorecard and scores to display for editing
        $.get("http://localhost/TeeBot/get_scores.php", { scorecard_id: scorecardId }, function (data) {
            for (let i = 0; i < data.scores.length; i++) {
                $(`#hole-${i + 1}`).val(data.scores[i]);
            }
    
            $('#scorecard-details').removeClass('hidden'); 
            $('#scores-form').data('scorecardId', scorecardId); 
        }).fail(function () {
            alert("Failed to load scorecard details.");
        });
    });
    

    loadScorecards();
});
