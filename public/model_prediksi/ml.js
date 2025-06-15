// Fungsi rekursif untuk prediksi satu pohon
function predictTree(tree, sample) {
    if (tree.value) {
        // Leaf node, kembalikan nilai prediksi (array probabilitas)
        return tree.value[0];
    }
    if (sample[tree.feature] <= tree.threshold) {
        return predictTree(tree.left, sample);
    } else {
        return predictTree(tree.right, sample);
    }
}

// Fungsi prediksi Random Forest (ensemble)
function predictRandomForest(forest, sample) {
    const votes = [];
    for (const tree of forest) {
        const pred = predictTree(tree, sample);
        votes.push(pred);
    }
    // Rata-rata probabilitas dari semua pohon
    const avgVotes = votes[0].map((_, i) => votes.reduce((sum, v) => sum + v[i], 0) / votes.length);
    // Kelas dengan probabilitas tertinggi
    const maxIndex = avgVotes.indexOf(Math.max(...avgVotes));
    return maxIndex; // indeks kelas prediksi
}
