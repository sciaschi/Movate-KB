class RollingTrigger
{
    constructor(onTrigger, waitMs) {
        this.onTrigger = onTrigger;
        this.waitMs = waitMs;
        this.timeoutId = null;
    }

    invoke() {
        let context = this,
            args    = arguments;

        if (this.timeoutId) {
            clearInterval(this.timeoutId);
        }

        this.timeoutId = setTimeout(function() {
            context.timeoutId = null;
            context.onTrigger.call(null, ...args);
        }, this.waitMs);
    }
}

let utils = {
    rollingTrigger: RollingTrigger,
    ratingColors: [
        {
            bg: "#00cec9",
            text: "#fff"
        },
        {
            bg: "#00b894",
            text: "#fff"
        },
        {
            bg: "#0984e3",
            text: "#fff"
        },
        {
            bg: "#74b9ff",
            text: "#fff"
        },
        {
            bg: "#fdcb6e",
            text: "#fff"
        },
        {
            bg: "#e17055",
            text: "#fff"
        },
        {
            bg: "#ff7675",
            text: "#fff"
        },
        {
            bg: "#d63031",
            text: "#fff"
        }
    ],

    setColorByNumber: function (num, el) {
        let color = this.ratingColors[num - 1] ?? this.ratingColors[1];
        el.setAttribute("style", "background-color: " + color.bg + "; color: " + color.text);
    },

    setColorByRangeNumber: function (rangeId, txtid) {
        let val = document.getElementById(rangeId).value,
            color = this.ratingColors[val - 1] ?? this.ratingColors[1],
            el = document.getElementById(txtid);

        el.setAttribute("style", "background-color: " + color.bg + "; color: " + color.text);
    },

    truncateString: function(str, n) {
        if (str.length > n) {
            return str.substring(0, n) + "...";
        } else {
            return str;
        }
    },

    getClickableLink: function(url) {
        if (!url.match(/^[a-zA-Z]+:\/\//))
        {
            url = 'http://' + url;
        }

        return url;
    },

    arrayRemove(arr, value) {

        return arr.filter(function(ele){
            return ele != value;
        });
    }
};
