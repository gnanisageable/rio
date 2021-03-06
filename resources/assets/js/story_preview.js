var template = require("./templates").story;

module.exports = function () {
    window.addEventListener("message", function (event) {
        var story = event.data['story'];
        if (story) {
            document.getElementById("story-container").innerHTML = template.render({
                storyData: story,
                food_stories: Array(20).fill(story),
                preview: true,
                config: qtConfig
            });
        }
    });
}
