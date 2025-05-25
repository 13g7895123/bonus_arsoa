 var second = 0;
    function countTime() {
        second++;
        if (second == 10) {
            location.href = base_url;
        }
        setTimeout("countTime()", 1000)
    }
countTime();