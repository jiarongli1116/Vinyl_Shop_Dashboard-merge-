<?php
//  ? 新增黑膠分頁
require_once "../components/connect.php";
require_once "../components/Utilities.php";

$sqlVinyl = "SELECT * FROM vinyl";
$sqlGenre = "SELECT * FROM vinyl_genre";
$sqlGender = "SELECT * FROM vinyl_gender";
$sqlAuthor = "SELECT * From vinyl_author";

$pageTitle = "新增黑膠唱片";
$cssList = ["../css/index.css", "css/product.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

try {
  $stmt = $pdo->prepare($sqlGenre);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmtGender = $pdo->prepare($sqlGender);
  $stmtGender->execute();
  $rowsGender = $stmtGender->fetchAll(PDO::FETCH_ASSOC);

  $stmtAuthor = $pdo->prepare($sqlAuthor);
  $stmtAuthor->execute();
  $rowsAuthor = $stmtAuthor->fetchAll(PDO::FETCH_ASSOC);

  $stmtVinyl = $pdo->prepare($sqlVinyl);
  $stmtVinyl->execute();
  $rowsVinyl = $stmtVinyl->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  // echo "錯誤: {{$e->getMessage()}} <br>";
  // exit;
  $errorMsg = $e->getMessage();
}
?>

<div class="content-section">

  <!-- 小標題 -->
  <div class="section-header">
    <h3 class="section-title">新增黑膠唱片</h3>
    <a href="./index.php" class="btn btn-secondary">回商品列表</a>
  </div>


  <form action="./doAddVinyl.php" method="post" enctype="multipart/form-data">
    <!-- 唱片 -->
    <div class="form-section">
      <div class="form-row avatar-row">
        <div class="form-group info-group">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label required" for="shs-id">唱片編號</label>
              <div class="input-group">
                <div class="input-group-text">
                  <span class="random-id cursor-pointer" id="random-id">隨機</span>
                </div>
                <input required name="shs-id" id="shs-id" type="text" class="form-control" placeholder="編號" readonly>
              </div>
              <div class="error-message" id="nameError"></div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label required" for="title">唱片名稱</label>
              <input required name="title" id="title" type="text" class="form-control" placeholder="唱片名稱">
              <!-- <div class="error-message" id="phoneError"></div> -->
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="author" class="form-label required">藝術家</label>
              <input required name="author" id="author" type="text" class="form-control" placeholder="藝術家"
                list="authorList">
              <datalist id="authorList">
                <?php foreach ($rowsAuthor as $row): ?>
                  <option value="<?= $row["author"] ?>"></option>
                <?php endforeach ?>
              </datalist>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="company" class="form-label required">公司</label>
              <input required name="company" id="company" type="text" class="form-control" placeholder="公司名稱">
              <div class="error-message" id="levelError"></div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label required" for="genre">風格</label>
              <select name="genre" id="genre" class="form-select" required>
                <option value selected disabled>請選擇</option>
                <?php foreach ($rows as $row): ?>
                  <option value="<?= $row["id"] ?>"><?= $row["genre"] ?></option>
                <?php endforeach ?>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label required" for="gender">類別</label>
              <select name="gender" id="gender" class="form-select" required>
                <option value selected disabled>請選擇</option>
              </select>
              <!-- <div class="error-message" id="levelError"></div> -->
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label required" for="price">價格</label>
              <input required name="price" id="price" type="number" class="form-control" placeholder="價格">
            </div>

            <div class="form-group">
              <label class="form-label required" for="stock">庫存</label>
              <input required name="stock" id="stock" type="number" class="form-control" placeholder="庫存數量">
              <!-- <div class="error-message" id="levelError"></div> -->
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="release_date">發行日期</label>
              <input name="release_date" id="release_date" type="date" class="form-control">
            </div>

            <div class="form-group">
              <label class="form-label required" for="format">規格</label>
              <input required name="format" id="format" type="text" class="form-control" placeholder="LP數量 ex: 1LP">
              <!-- <div class="error-message" id="levelError"></div> -->
            </div>
          </div>
        </div>

        <div class="form-group avatar-group">
          <label for="imageInput" class="form-label"></label>
          <div class="avatar-upload-container">
            <div class="avatar-preview flex-center rounded-5" id="previewImage">
              <div class="wh600 flex-center bg-secondary text-white fs-2 rounded-3">
                圖片預覽位置
              </div>
            </div>
            <input type="file" id="imageInput" name="myFile" class="form-control mt-4 required" accept="image/*" required>
            <small class="form-text">支援 JPG、PNG、GIF 格式，檔案大小不超過 2MB</small>
          </div>
        </div>
      </div>


      <div class="form-section">
        <div class="form-group mb-3">
          <label class="form-label" for="desc_text">介紹</label>
          <textarea name="desc_text" id="desc_text" class="form-control" rows="4" placeholder="專輯介紹"></textarea>
        </div>
      </div>

      <div class="form-section">
        <div class="form-group mb-3">
          <label class="form-label" for="playlist">歌曲清單</label>
          <textarea name="playlist" id="playlist" class="form-control" rows="6" placeholder="每首歌換行輸入"></textarea>
        </div>
      </div>

      <!-- 按鈕 -->
      <div class="text-end">
        <button type="submit" class="btn btn-info">送出</button>
        <a class="btn btn-secondary" href="./index.php">取消</a>
      </div>
  </form>






</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script>

  // 放你的 JS 代碼（包括 event listener）
  const genderSelect = document.getElementById("gender");
  const genreSelect = document.getElementById("genre");
  const random = document.getElementById("random-id")
  const randomInput = document.getElementById("shs-id")

  const input = document.getElementById('imageInput');
  const preview = document.getElementById('previewImage');

  random.addEventListener("click", () => {
    const hex = Math.floor(Math.random() * 0xFFFFFFFF)
      .toString(16)
      .padStart(8, '0')
      .toUpperCase();

    randomInput.value = hex
  })

  const genderOptionsRaw = <?= json_encode($rowsGender) ?>;

  // 轉換為 genre_id => [gender, gender, ...]
  const genderOptions = {};
  genderOptionsRaw.forEach(row => {
    const genreId = row.genre_id;
    if (!genderOptions[genreId]) {
      genderOptions[genreId] = [];
    }
    genderOptions[genreId].push({
      id: row.id,
      gender: row.gender
    });
  });

  genreSelect.addEventListener("change", function () {
    const genreId = this.value;
    const genders = genderOptions[genreId] || [];

    console.log(genreId);

    // 清空原本選項
    genderSelect.innerHTML = '<option value selected disabled>請選擇</option>';

    // 加入新的選項
    genders.forEach(g => {
      const opt = document.createElement("option");
      opt.value = g.id;
      opt.textContent = g.gender;
      genderSelect.appendChild(opt);
    });
  });

  input.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        // 清空舊的預覽（如果有的話）
        preview.innerHTML = '';

        // 建立新的 <img> 標籤並插入
        const img = document.createElement('img');
        img.src = e.target.result;
        img.alt = '預覽圖片';
        img.className = 'img-fluid rounded-3'; // Bootstrap 樣式
        preview.appendChild(img);
      }
      reader.readAsDataURL(file);
    }
  });


</script>
<?php include "../template_btm.php"; ?>