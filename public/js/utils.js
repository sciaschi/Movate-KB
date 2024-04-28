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
            bg: "#ffa502",
            text: "#fff"
        },
        {
            bg: "#d63031",
            text: "#fff"
        },
        {
            bg: "#0984e3",
            text: "#fff"
        }
    ],

    setColorByNumber: function (num, el) {
        let color = this.ratingColors[num - 1] ?? this.ratingColors[1];
        el.setAttribute("style", "background-color: " + color.bg);
    },

    setColorByRangeNumber: function (rangeId, txtid) {
        let val = document.getElementById(rangeId).value,
            color = this.ratingColors[val - 1] ?? this.ratingColors[1],
            el = document.getElementById(txtid);

        el.setAttribute("style", "background-color: " + color.bg);
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
    },

    getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    },

    convertRating(rating) {
        let str;
        switch(parseInt(rating)) {
            case 1:
                str = 'Auto Unflag';
                break;
            case 2:
                str = 'Needs Context';
                break;
            case 3:
                str = 'Auto Flag';
                break;
            default:
                str = 'Unknown'
        }
        return str;
    },
};
export default utils
