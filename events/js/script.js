$( function(){
    $('.date-picker').datepicker({dateFormat: 'yy-mm-dd'});
    
    var startDate = $('.start-date');
    var endDate = $('.end-date');
    
    startDate.on('change', function(){
        if ( endDate.val() === null ) {
            endDate.val(startDate.val());
        } else if ( endDate.val() < startDate.val() ) {
            endDate.val(startDate.val());
        }
    });
    
    
    // main page
    
    var goLeftNext = $('div.goLeftNext');
    var goRightNext = $('div.goRightNext');
    
    var nextEventsBox = $('div.nextEventsItems');
    var nextEventArray = nextEventsBox.find('div.nextEvent');
    
    var counterNext = 4;
    var nextEventsNumber = nextEventArray.length;
    
    
    goLeftNext.on('click', function(){
        if (counterNext>4)
        {
            counterNext--;
            nextEventArray[counterNext].classList.toggle("invisible");
            nextEventArray[counterNext-4].classList.toggle("invisible");
            
        }
    });
    
    goRightNext.on('click', function(){
        if (counterNext<nextEventsNumber)
        {
            nextEventArray[counterNext].classList.toggle("invisible");
            nextEventArray[counterNext-4].classList.toggle("invisible");
            counterNext++; 
        }
        
    });
    
    var goLeftLast = $('div.goLeftLast');
    var goRightLast = $('div.goRightLast');
    
    var lastEventsBox = $('div.lastEventsItems');
    var lastEventArray = lastEventsBox.find('div.lastEvent');
    
    var counterLast = 4;
    var lastEventsNumber = lastEventArray.length;
    
    
    
    goLeftLast.on('click', function(){
        if (counterLast>4)
        {
            counterLast--;
            lastEventArray[counterLast].classList.toggle("invisible");
            lastEventArray[counterLast-4].classList.toggle("invisible");
            
        }
    });
    
    goRightLast.on('click', function(){
        if (counterLast<lastEventsNumber)
        {
            lastEventArray[counterLast].classList.toggle("invisible");
            lastEventArray[counterLast-4].classList.toggle("invisible");
            counterLast++; 
        }
        
    });
    
    // Moduł users
    
    var deleteUser = $('.deleteUser');
    deleteUser.on('click', function(e){
        var user = e.target.parentElement.parentElement.querySelector('td').innerHTML;
        if ( !confirm("Czy na pewno chcesz usunąć z bazy użytkownika: "+user+" ? "))
        {
            e.preventDefault();
        }
    });
    
    // wyszukiwanie użytkownika w module users
    
    var searchInput = document.querySelector('input.searchUser');
    
    if (searchInput)
    {
        searchInput.addEventListener('keyup', function(e){
            var input, filter, table, tr, td, i;
            input = e.target;
            filter = input.value.toUpperCase();
            table = document.querySelector("table#usersTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if ( td.innerHTML.toUpperCase().indexOf(filter) > -1  ) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                } 
            }
        });
    }
    
    // sortowanie
    
     
    // wg pierwszej kolumny
    var sortButton0 = document.querySelector('button.sortBy0');
    
    if (sortButton0)
    {
    
        sortButton0.addEventListener('click', function(){
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.querySelector("table#usersTable");
            if (!table)
            {
               table = document.querySelector("table#categoriesTable"); 
            }
            switching = true;
            // Set the sorting direction to ascending:
            dir = "asc"; 
            /* Make a loop that will continue until
            no switching has been done: */
            while (switching) {
                // Start by saying: no switching is done:
               switching = false;
               rows = table.rows;
               /* Loop through all table rows (except the
               first, which contains table headers): */
               for (i = 1; i < (rows.length - 1); i++) {
                   // Start by saying there should be no switching:
                   shouldSwitch = false;
                   /* Get the two elements you want to compare,
                   o ne from current row and one from the next: */
                   x = rows[i].getElementsByTagName("TD")[0];
                   y = rows[i + 1].getElementsByTagName("TD")[0];
                   /* Check if the two rows should switch place,
                   based on the direction, asc or desc: */
                   if (dir == "asc") {
                       if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                       // If so, mark as a switch and break the loop:
                       shouldSwitch = true;
                       break;
                       }
                   } else if (dir == "desc") {
                       if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                       // If so, mark as a switch and break the loop:
                       shouldSwitch = true;
                       break;
                       }
                   }
               }
               if (shouldSwitch) {
                   /* If a switch has been marked, make the switch
                   and mark that a switch has been done: */
                   rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                   switching = true;
                   // Each time a switch is done, increase this count by 1:
                   switchcount ++; 
               } else {
                   /* If no switching has been done AND the direction is "asc",
                   set the direction to "desc" and run the while loop again. */
                   if (switchcount == 0 && dir == "asc") {
                       dir = "desc";
                       switching = true;
                   }
               }
            }

        });
    }
    
    // sortowanie wg drugiej kolumny
    var sortButton1 = document.querySelector('button.sortBy1');
    
    if (sortButton1)
    {
    
        sortButton1.addEventListener('click', function (e){

            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.querySelector("table#usersTable");
            if (!table)
            {
               table = document.querySelector("table#categoriesTable"); 
            }
            switching = true;
            // Set the sorting direction to ascending:
            dir = "asc"; 
            /* Make a loop that will continue until
            no switching has been done: */
            while (switching) {
                // Start by saying: no switching is done:
               switching = false;
               rows = table.rows;
               /* Loop through all table rows (except the
               first, which contains table headers): */
               for (i = 1; i < (rows.length - 1); i++) {
                   // Start by saying there should be no switching:
                   shouldSwitch = false;
                   /* Get the two elements you want to compare,
                   o ne from current row and one from the next: */
                   x = rows[i].getElementsByTagName("TD")[1];
                   y = rows[i + 1].getElementsByTagName("TD")[1];
                   /* Check if the two rows should switch place,
                   based on the direction, asc or desc: */
                   if (dir == "asc") {
                       if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                       // If so, mark as a switch and break the loop:
                       shouldSwitch = true;
                       break;
                       }
                   } else if (dir == "desc") {
                       if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                       // If so, mark as a switch and break the loop:
                       shouldSwitch = true;
                       break;
                       }
                   }
               }
               if (shouldSwitch) {
                   /* If a switch has been marked, make the switch
                   and mark that a switch has been done: */
                   rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                   switching = true;
                   // Each time a switch is done, increase this count by 1:
                   switchcount ++; 
               } else {
                   /* If no switching has been done AND the direction is "asc",
                   set the direction to "desc" and run the while loop again. */
                   if (switchcount == 0 && dir == "asc") {
                       dir = "desc";
                       switching = true;
                   }
               }
            }

        });
    }
    
    // sortowanie wg 3 kolumny
    var sortButton2 = document.querySelector('button.sortBy2');
    
    if (sortButton2)
    {
    
        sortButton2.addEventListener('click', function (e){

            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.querySelector("table#usersTable");
            if (!table)
            {
               table = document.querySelector("table#categoriesTable"); 
            }
            switching = true;
            // Set the sorting direction to ascending:
            dir = "asc"; 
            /* Make a loop that will continue until
            no switching has been done: */
            while (switching) {
                // Start by saying: no switching is done:
               switching = false;
               rows = table.rows;
               /* Loop through all table rows (except the
               first, which contains table headers): */
               for (i = 1; i < (rows.length - 1); i++) {
                   // Start by saying there should be no switching:
                   shouldSwitch = false;
                   /* Get the two elements you want to compare,
                   o ne from current row and one from the next: */
                   x = rows[i].getElementsByTagName("TD")[2];
                   y = rows[i + 1].getElementsByTagName("TD")[2];
                   /* Check if the two rows should switch place,
                   based on the direction, asc or desc: */
                   if (dir == "asc") {
                       if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                       // If so, mark as a switch and break the loop:
                       shouldSwitch = true;
                       break;
                       }
                   } else if (dir == "desc") {
                       if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                       // If so, mark as a switch and break the loop:
                       shouldSwitch = true;
                       break;
                       }
                   }
               }
               if (shouldSwitch) {
                   /* If a switch has been marked, make the switch
                   and mark that a switch has been done: */
                   rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                   switching = true;
                   // Each time a switch is done, increase this count by 1:
                   switchcount ++; 
               } else {
                   /* If no switching has been done AND the direction is "asc",
                   set the direction to "desc" and run the while loop again. */
                   if (switchcount == 0 && dir == "asc") {
                       dir = "desc";
                       switching = true;
                   }
               }
            }

        });
    }
    
    // sortowanie wg czwartej kolumny
    var sortButton3 = document.querySelector('button.sortBy3');
    
    if (sortButton3)
    {
    
        sortButton3.addEventListener('click', function (e){

            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.querySelector("table#usersTable");
            if (!table)
            {
               table = document.querySelector("table#categoriesTable"); 
            }
            switching = true;
            // Set the sorting direction to ascending:
            dir = "asc"; 
            /* Make a loop that will continue until
            no switching has been done: */
            while (switching) {
                // Start by saying: no switching is done:
               switching = false;
               rows = table.rows;
               /* Loop through all table rows (except the
               first, which contains table headers): */
               for (i = 1; i < (rows.length - 1); i++) {
                   // Start by saying there should be no switching:
                   shouldSwitch = false;
                   /* Get the two elements you want to compare,
                   o ne from current row and one from the next: */
                   x = rows[i].getElementsByTagName("TD")[3];
                   y = rows[i + 1].getElementsByTagName("TD")[3];
                   /* Check if the two rows should switch place,
                   based on the direction, asc or desc: */
                   if (dir == "asc") {
                       if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                       // If so, mark as a switch and break the loop:
                       shouldSwitch = true;
                       break;
                       }
                   } else if (dir == "desc") {
                       if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                       // If so, mark as a switch and break the loop:
                       shouldSwitch = true;
                       break;
                       }
                   }
               }
               if (shouldSwitch) {
                   /* If a switch has been marked, make the switch
                   and mark that a switch has been done: */
                   rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                   switching = true;
                   // Each time a switch is done, increase this count by 1:
                   switchcount ++; 
               } else {
                   /* If no switching has been done AND the direction is "asc",
                   set the direction to "desc" and run the while loop again. */
                   if (switchcount == 0 && dir == "asc") {
                       dir = "desc";
                       switching = true;
                   }
               }
            }

        });
    }
       
    
});



