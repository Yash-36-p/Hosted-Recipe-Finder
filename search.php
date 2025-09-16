 <?php
include 'config.php';

header('Content-Type: application/json');

if (isset($_GET['ingredients'])) {
    $ingredients = urlencode($_GET['ingredients']);
    $cuisine = isset($_GET['cuisine']) && $_GET['cuisine'] !== "" ? "&cuisine=" . urlencode($_GET['cuisine']) : "";
    $diet = isset($_GET['diet']) && $_GET['diet'] !== "" ? "&diet=" . urlencode($_GET['diet']) : "";

    $url = "https://api.spoonacular.com/recipes/complexSearch?includeIngredients={$ingredients}{$cuisine}{$diet}&number=10&addRecipeInformation=true&apiKey={$API_KEY}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo json_encode(["results" => [], "error" => curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    $recipes = json_decode($response, true);
    $results = [];

    if (isset($recipes['results'])) {
        foreach ($recipes['results'] as $recipe) {
            $results[] = [
                "title" => $recipe['title'],
                "image" => $recipe['image'],
                "sourceUrl" => $recipe['sourceUrl']
            ];
        }
    }

    echo json_encode(["results" => $results]);
} else {
    echo json_encode(["results" => []]);
}
?>