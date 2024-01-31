<?php
$winner = "";
$board = [
    ['', '', ''],
    ['', '', ''],
    ['', '', '']
];

function checkWinner($board)
{
    for ($i = 0; $i < 3; $i++) {
        if ($board[$i][0] != '' && $board[$i][0] == $board[$i][1] && $board[$i][1] == $board[$i][2]) {
            return $board[$i][0];
        }
    }

    for ($j = 0; $j < 3; $j++) {
        if ($board[0][$j] != '' && $board[0][$j] == $board[1][$j] && $board[1][$j] == $board[2][$j]) {
            return $board[0][$j];
        }
    }

    if ($board[0][0] != '' && $board[0][0] == $board[1][1] && $board[1][1] == $board[2][2]) {
        return $board[0][0];
    }

    if ($board[0][2] != '' && $board[0][2] == $board[1][1] && $board[1][1] == $board[2][0]) {
        return $board[0][2];
    }

    return '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $row = $_POST['row'];
    $col = $_POST['col'];
    $player = $_POST['player'];

    if ($board[$row][$col] === '') {
        $board[$row][$col] = $player;

        $winner = checkWinner($board);

        if ($winner === '') {

            $emptyCells = [];
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    if ($board[$i][$j] === '') {
                        $emptyCells[] = ['row' => $i, 'col' => $j];
                    }
                }
            }

            if (!empty($emptyCells)) {
                $cpuMove = $emptyCells[array_rand($emptyCells)];
                $board[$cpuMove['row']][$cpuMove['col']] = 'O';

                $winner = checkWinner($board);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tic Tac Toe</title>
</head>
<body>
  <h1>Tic Tac Toe</h1>
    <div id="board" class="board">
        <?php for ($i = 0; $i < 3; $i++) : ?>
            <div class="row">
                <?php for ($j = 0; $j < 3; $j++) : ?>
                    <form method="post">
                        <input type="hidden" name="row" value="<?= $i ?>">
                        <input type="hidden" name="col" value="<?= $j ?>">
                        <input type="hidden" name="player" value="X">
                        <button class="cell" <?= $board[$i][$j] !== '' ? 'disabled' : '' ?>><?= $board[$i][$j] ?></button>
                    </form>
                <?php endfor; ?>
            </div>
        <?php endfor; ?>
    </div>
    <p><?= $winner !== '' ? 'Winner: ' . $winner : '' ?></p>
  <footer>Made By Hendrich Buhrer</footer>
</body>
</html>