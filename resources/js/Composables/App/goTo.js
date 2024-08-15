export default (url, target = null) => {
    if (target) {
        window.open(url, target)
        return
    }
    window.location.href = url
}