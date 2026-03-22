  <?php
$alunos = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nomes = $_POST["nome"];
    $nota1 = $_POST["nota1"];
    $nota2 = $_POST["nota2"];
    $nota3 = $_POST["nota3"];
    $nota4 = $_POST["nota4"];

    for ($i = 0; $i < count($nomes); $i++) {

        if (empty($nomes[$i])) continue;

        $notas = [$nota1[$i], $nota2[$i], $nota3[$i], $nota4[$i]];

        // validação
        foreach ($notas as $nota) {
            if (!is_numeric($nota) || $nota < 0 || $nota > 10) {
                die("Erro nas notas do aluno: " . $nomes[$i]);
            }
        }

        $media = array_sum($notas) / 4;
        // Armazenar os dados do aluno em um array 
        $alunos[] = [
            "nome" => $nomes[$i],
            "notas" => $notas,
            "media" => $media
        ];
    }

    // Ordenar pela média
    usort($alunos, function ($a, $b) {
        return $b["media"] <=> $a["media"];
    });
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas 8º Ano A</title>
    <link rel="stylesheet" href="notas.css">
</head>
<body>

<h2>Cadastro de Notas - 8º Ano A</h2>
<!-- Formulário para adicionar alunos -->
<form method="POST">
    <div id="alunos"></div>
    <button type="button" onclick="addAluno()">Adicionar aluno</button><br><br>
    <div class="instrucoes">
        <h3>Instruções:</h3>
        <p>Adicione todas as áreas de aluno antes de incluir os dados.</p>
        <p>Adicione os alunos e suas respectivas notas. Cada aluno deve ter um nome e quatro notas (uma para cada bimestre).</p>
        <p>Após adicionar os alunos, clique em "Gerar Tabela" para calcular as médias e exibir os resultados.</p>
        <p> Observação: As notas devem ser números entre 0 e 10. O sistema irá calcular a média de cada aluno e a média geral da turma, exibindo os resultados em uma tabela organizada.</p>
        <p> O sistema também indicará a situação de cada aluno (aprovado ou reprovado) com base na média, utilizando uma coloração diferente para facilitar a visualização.</p>
        <p>ATENÇÃO! Após gerar a tabela, não poderá ser adicionado mais alunos, para garantir a integridade dos dados apresentados.</p>
    </div>
    <button type="submit">Gerar Tabela</button>
</form>

<script>
function addAluno() {
    document.getElementById("alunos").innerHTML += `
        <hr>
        Nome Aluno: <input type="text" name="nome[]" required><br>
        Nota 1: <input type="number" name="nota1[]" step="0.1" min="0" max="10" required><br>
        Nota 2: <input type="number" name="nota2[]" step="0.1" min="0" max="10" required><br>
        Nota 3: <input type="number" name="nota3[]" step="0.1" min="0" max="10" required><br>
        Nota 4: <input type="number" name="nota4[]" step="0.1" min="0" max="10" required><br>
    `;
}
</script>

<?php if (!empty($alunos)): ?>

<!-- Tabela de resultados -->
<h2>Resultado</h2>

<table>
    <tr>
        <th>Nome Aluno</th>
        <th>1º semestre</th>
        <th>2º semestre</th>
        <th>3º semestre</th>
        <th>4º semestre</th>
        <th>Média final</th>
    </tr>

    <?php
    // Calcular a média do aluno e da turma
    $soma = 0;
    foreach ($alunos as $aluno):
        $soma += $aluno["media"];
        $classe = ($aluno["media"] >= 6) ? "aprovado" : "reprovado";
    ?>
    <tr>
        <!-- Exibir o nome do aluno -->
        <td><?= $aluno["nome"] ?></td>
        <!-- Exibir as notas do aluno -->
        <td><?= $aluno["notas"][0] ?></td>
        <td><?= $aluno["notas"][1] ?></td>
        <td><?= $aluno["notas"][2] ?></td>
        <td><?= $aluno["notas"][3] ?></td>
        <!-- Exibir a média do aluno -->
        <td class="<?= $classe ?>">
            <?= number_format($aluno["media"], 1) ?>
        </td>
    </tr>

    <?php endforeach; ?>  <!-- Fim do loop dos alunos -->

    <tr>
        <!-- Exibir a média da turma -->
        <td colspan="5"><strong>Média da turma</strong></td>
        <td><strong><?= number_format($soma / count($alunos), 1) ?></strong></td>
    </tr>

</table>

<?php endif; ?>

<!-- Nesta atividade ao invés de usar o formulário, utilizei um array para armazenar os dados dos alunos, para que possam ser adicionadas diversas entradas, solicitei ao final o calculo de médias dos alunos (mostrando coloração conforme aprovação) e da turma conforme a orientação da atividade da agenda 05, inclui além disso o estilo em css para melhorar a experiência ao acessar a página -->

</body>
</html>