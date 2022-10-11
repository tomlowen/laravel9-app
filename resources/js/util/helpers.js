/**
 * Convert a number into a string of hours and minutes (e.g. 150 --> 2H 30MIN)
 * @param {int} $time
 * @return {string}
 */
export function formatTime($time) {
    const h = Math.floor($time / 60);
    const m = $time % 60;

    if (!h) {
        return m + ' MIN'
    } else {
        return h + ' H ' + m + ' MIN'
    }
}
