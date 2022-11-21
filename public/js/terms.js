var terms = {
    selectedTerm: null,
    grid: null,

    init: function() {
        //this.initBindings();
    },

    initBindings: function() {
        this.grid = new gridjs.Grid({
            columns: ["Links"],
            data: this.links
        }).render(document.getElementById("detailsLinksTable"));
    },

    setSelectedTerm: function(term) {
        selectedTermVal = term;
    }
}
