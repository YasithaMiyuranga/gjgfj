document.querySelector('form').addEventListener('submit', function(e) {
    var submitButton = e.target.querySelector('button[type="submit"]');

    // Disable the button to prevent double-clicks
    if (submitButton) {
        submitButton.disabled = true;
    }

    //  prevent duplicate submissions
    if (this.classList.contains('submitted')) {
        e.preventDefault(); // Prevent form submission if already submitted
        return false;
    }

    // Add a class to mark the form as submitted
    this.classList.add('submitted');
});


// for DataTable
$(document).ready(function () {
    comman_function();

    // Initialize the general DataTable if it exists
    if ($(".dataTable").length > 0) {
        const dataTableGeneral = new DataTable(".dataTable", {
            responsive: true,
            "bDestroy": true,
            layout: {
                topEnd: {
                    search: {
                        placeholder: 'Search here...'
                    }
                }
            },
        });
    }

    // Initialize the data-table-cash-flow if it exists
    if ($(".data-table-cash-flow").length > 0) {
        const dataTableCashFlow = new DataTable(
            ".data-table-cash-flow",
            {
                paging: false,
                searchable: false,
                responsive: true,
                "bDestroy": true,
                dom: 't',
            }
        );
    }
    if ($(".descending-order").length > 0) {
        const dataTableCashFlow = new DataTable(
            ".descending-order",
            {
                order: [[0, 'desc']],
                responsive: true,
                "bDestroy": true,
                layout: {
                    topEnd: {
                        search: {
                            placeholder: 'Search here...'
                        }
                    }
                },
            }
        );
    }
});


$(document).ready(function () {
    const backIcon = document.querySelector('.dsk-back-arrow');
    const dskHambMenu = document.querySelector('.dsk-hamburger');
    const dashSideBarWrap = document.querySelector('.dash-sidebar');
    const dashHeader = document.querySelector('.dash-header');
    const dashContainer = document.querySelector('.dash-container');

    dskHambMenu.style.display = "none";

    backIcon.addEventListener('click', () => {
    backIcon.style.display="none";
    dashSideBarWrap.style.display = "none";
    dskHambMenu.style.display = "flex";
    dashHeader.style.left = "30px";
    dashContainer.style.marginLeft= "0";
    });

    dskHambMenu.addEventListener('click', () => {
    dskHambMenu.style.display = "none";
    dashSideBarWrap.style.display = "block";
    backIcon.style.display="flex";
    dashHeader.style.left = "calc(255px + 40px)";
    dashContainer.style.marginLeft= "calc(255px + 15px)";
    })
});



