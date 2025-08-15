# DB スキーマ設計書

## 1. 概要

このドキュメントは、アプリケーションのデータベーススキーマについて定義したものです。
各テーブルの構造、カラムの定義、テーブル間のリレーションについて説明します。

## 2. テーブル一覧

| No. | テーブル名          | 役割・管理内容                                         |
| --- | ------------------- | ------------------------------------------------------ |
| 1   | `users`             | ユーザー情報（管理職/スタッフ）を管理                  |
| 2   | `products`          | 商品（SPEC）の基本情報、目標重量、単価                 |
| 3   | `ingredients`       | 食材のマスタ情報を管理                                 |
| 4   | `ingredient_usages` | 使用食材の記録（何を、いつ、どれだけ使ったか）         |
| 5   | `sales_forecasts`   | 売上予測の記録（日付単位で予測金額を保存）             |
| 6   | `spec_ingredients`  | SPEC ごとの使用食材リスト（中間テーブル）              |
| 7   | `recipe_steps`      | 調理手順と調理途中画像の管理                           |
| 8   | `volumes`           | 発注管理（いつ、どの商品を発注したかの親データ）       |
| 9   | `volume_details`    | 発注の cell ごとの詳細（重量、金額）                   |
| 10  | `destroys`          | 廃棄管理（何を、いつ、どれだけ廃棄したか）             |
| 11  | `weights`           | 品質管理（実測値の記録）                               |
| 12  | `sales`             | 売上管理（売上金額の記録）                             |
| 13  | `schedules`         | 製造予定の管理（いつ、どの商品を、何 cell 作る予定か） |

## 3. テーブル定義詳細

### 3.1. `users` - ユーザー情報

使用者情報を管理します。

| カラム名     | 型            | 制約            | 備考                                        |
| ------------ | ------------- | --------------- | ------------------------------------------- |
| `id`         | `BIGINT`      | `PRIMARY KEY`   | ユーザー ID（主キー）                       |
| `login_id`   | `VARCHAR(50)` | `NOT NULL`      | ログイン用 ID（社員 ID や倉庫番号）         |
| `password`   | `VARCHAR`     | `NOT NULL`      | パスワード                                  |
| `is_manager` | `BOOLEAN`     | `DEFAULT FALSE` | 管理職フラグ（管理者:true, スタッフ:false） |
| `created_at` | `TIMESTAMP`   |                 | 登録日時                                    |
| `updated_at` | `TIMESTAMP`   | `NULLABLE`      | 更新日時                                    |

---

### 3.2. `products` - 商品情報

商品を管理します。

| カラム名        | 型              | 制約                     | 備考                                  |
| --------------- | --------------- | ------------------------ | ------------------------------------- |
| `spec_code`     | `VARCHAR(10)`   | `PRIMARY KEY`            | 製造番号（主キー）                    |
| `name`          | `VARCHAR(100)`  | `NOT NULL`               | 商品名                                |
| `image_path`    | `VARCHAR(255)`  | `NULLABLE`               | 商品画像のパス                        |
| `price`         | `DECIMAL(10,2)` | `NULLABLE`               | 100g あたりの価格（円）               |
| `target_weight` | `DECIMAL(6,2)`  | `NOT NULL`               | 目標重量（g）                         |
| `category`      | `VARCHAR(50)`   | `NULLABLE`               | カテゴリー（肉、魚、サラダ等）        |
| `user_id`       | `BIGINT`        | `FOREIGN KEY (users.id)` | 登録・更新したユーザー ID（外部キー） |
| `created_at`    | `TIMESTAMP`     | `NOT NULL`               | 作成日時                              |
| `updated_at`    | `TIMESTAMP`     | `NOT NULL`               | 更新日時                              |

---

### 3.3. `recipe_steps` - 調理手順

調理手順と画像を管理します。

| カラム名           | 型             | 制約                               | 備考                           |
| ------------------ | -------------- | ---------------------------------- | ------------------------------ |
| `id`               | `BIGINT`       | `PRIMARY KEY`                      | 手順 ID（主キー）              |
| `spec_code`        | `VARCHAR(10)`  | `FOREIGN KEY (products.spec_code)` | 対象商品の製造番号（外部キー） |
| `step_order`       | `INT`          | `NOT NULL`                         | 手順の順番（1,2,3…）           |
| `step_description` | `TEXT`         | `NOT NULL`                         | 手順の説明文                   |
| `step_image_path`  | `VARCHAR(255)` | `NULLABLE`                         | 調理途中の画像パス（任意）     |
| `created_at`       | `TIMESTAMP`    | `NOT NULL`                         | 作成日時                       |
| `updated_at`       | `TIMESTAMP`    | `NOT NULL`                         | 更新日時                       |

---

### 3.4. `ingredients` - 食材情報

食材を管理します。

| カラム名            | 型             | 制約                               | 備考                     |
| ------------------- | -------------- | ---------------------------------- | ------------------------ |
| `id`                | `BIGINT`       | `PRIMARY KEY`                      | 食材 ID（主キー）        |
| `name`              | `VARCHAR(100)` | `NOT NULL`                         | 食材名                   |
| `category`          | `VARCHAR(50)`  | `NULLABLE`                         | カテゴリー（肉、野菜等） |
| `product_spec_code` | `BIGINT`       | `FOREIGN KEY (products.spec_code)` | 製造番号（外部キー）     |
| `stock_quantity`    | `DECIMAL(6,2)` | `DEFAULT 0`                        | 在庫数（単位は kg や個） |
| `unit`              | `VARCHAR(20)`  | `NULLABLE`                         | 単位（kg、個、L など）   |
| `status`            | `ENUM`         |                                    | 在庫状態                 |
| `created_at`        | `TIMESTAMP`    |                                    | 作成日時                 |
| `updated_at`        | `TIMESTAMP`    | `DEFAULT CURRENT_TIMESTAMP`        | 更新日時                 |

---

### 3.5. `ingredient_usages` - 食材使用履歴

どの食材をいつ、どれだけ使ったかを管理します。

| カラム名        | 型             | 制約                           | 備考                     |
| --------------- | -------------- | ------------------------------ | ------------------------ |
| `id`            | `BIGINT`       | `PRIMARY KEY`                  | 使用履歴 ID（主キー）    |
| `ingredient_id` | `BIGINT`       | `FOREIGN KEY (ingredients.id)` | 食材 ID（外部キー）      |
| `quantity_used` | `DECIMAL(6,2)` | `NOT NULL`                     | 使用量（kg, 個, L など） |
| `used_at`       | `DATE`         | `NOT NULL`                     | 使用日                   |
| `created_at`    | `TIMESTAMP`    | `NOT NULL`                     | 作成日時                 |
| `updated_at`    | `TIMESTAMP`    | `DEFAULT CURRENT_TIMESTAMP`    | 更新日時                 |

---

### 3.6. `sales_forecasts` - 売上予測

分析結果を管理します。

| カラム名         | 型              | 制約                        | 備考               |
| ---------------- | --------------- | --------------------------- | ------------------ |
| `id`             | `BIGINT`        | `PRIMARY KEY`               | 予測 ID（主キー）  |
| `date`           | `DATE`          | `NOT NULL`                  | 対象日             |
| `product_name`   | `VARCHAR(100)`  | `NULLABLE`                  | 商品名             |
| `forecast_value` | `DECIMAL(10,2)` | `NOT NULL`                  | 予測売上金額（円） |
| `created_at`     | `TIMESTAMP`     | `NOT NULL`                  | 作成日時           |
| `updated_at`     | `TIMESTAMP`     | `DEFAULT CURRENT_TIMESTAMP` | 更新日時           |

---

### 3.7. `spec_ingredients` - 商品別使用食材 (中間テーブル)

商品ごとに使用する食材のリストを管理します。

| カラム名            | 型             | 制約                               | 備考                           |
| ------------------- | -------------- | ---------------------------------- | ------------------------------ |
| `id`                | `BIGINT`       | `PRIMARY KEY`                      | レコード ID（主キー）          |
| `spec_code`         | `VARCHAR(10)`  | `FOREIGN KEY (products.spec_code)` | 対象商品の製造番号（外部キー） |
| `ingredient_id`     | `BIGINT`       | `FOREIGN KEY (ingredients.id)`     | 使用する食材の ID（外部キー）  |
| `quantity_per_unit` | `DECIMAL(6,2)` | `NOT NULL`                         | 1 単位あたりの使用量           |
| `unit`              | `VARCHAR(20)`  | `NULLABLE`                         | 単位（kg、g、個など）          |
| `created_at`        | `TIMESTAMP`    | `NOT NULL`                         | 作成日時                       |
| `updated_at`        | `TIMESTAMP`    | `DEFAULT CURRENT_TIMESTAMP`        | 更新日時                       |

---

### 3.8. `volumes` - 発注情報

外部発注を管理します。

| カラム名        | 型             | 制約                               | 備考                                |
| --------------- | -------------- | ---------------------------------- | ----------------------------------- |
| `id`            | `BIGINT`       | `PRIMARY KEY`                      | 発注 ID（主キー）                   |
| `spec_code`     | `VARCHAR(10)`  | `FOREIGN KEY (products.spec_code)` | 対象商品の製造番号（外部キー）      |
| `order_date`    | `DATE`         | `NOT NULL`                         | 発注日                              |
| `supplier_name` | `VARCHAR(100)` | `NULLABLE`                         | 発注元名                            |
| `user_id`       | `BIGINT`       | `FOREIGN KEY (users.id)`           | 発注を行ったユーザー ID（外部キー） |
| `created_at`    | `TIMESTAMP`    | `NOT NULL`                         | 作成日時                            |
| `updated_at`    | `TIMESTAMP`    | `DEFAULT CURRENT_TIMESTAMP`        | 更新日時                            |

---

### 3.9. `volume_details` - 発注明細

cell 毎の明細を管理します。

| カラム名           | 型              | 制約                        | 備考                            |
| ------------------ | --------------- | --------------------------- | ------------------------------- |
| `id`               | `BIGINT`        | `PRIMARY KEY`               | cell 情報の一意な ID（主キー）  |
| `volume_id`        | `BIGINT`        | `FOREIGN KEY (volumes.id)`  | 発注 ID（外部キー）             |
| `cell_number`      | `INT`           | `NOT NULL`                  | 発注した cell の連番            |
| `actual_weight`    | `DECIMAL(6,2)`  | `NOT NULL`                  | 実際の重量(g)                   |
| `calculated_price` | `DECIMAL(10,2)` | `NULLABLE`                  | （単価 × 重量）の計算結果（円） |
| `created_at`       | `TIMESTAMP`     | `NOT NULL`                  | 作成日時                        |
| `updated_at`       | `TIMESTAMP`     | `DEFAULT CURRENT_TIMESTAMP` | 更新日時                        |

---

### 3.10. `destroys` - 廃棄情報

廃棄を管理します。

| カラム名           | 型             | 制約                               | 備考                                  |
| ------------------ | -------------- | ---------------------------------- | ------------------------------------- |
| `id`               | `BIGINT`       | `PRIMARY KEY`                      | 廃棄記録の ID（主キー）               |
| `spec_code`        | `VARCHAR(10)`  | `FOREIGN KEY (products.spec_code)` | 廃棄対象商品の製造番号（外部キー）    |
| `destroyed_weight` | `DECIMAL(6,2)` | `NOT NULL`                         | 廃棄した重量(g や kg)                 |
| `destroy_date`     | `DATE`         | `NOT NULL`                         | 廃棄した日                            |
| `user_id`          | `BIGINT`       | `FOREIGN KEY (users.id)`           | 廃棄を記録したユーザー ID（外部キー） |
| `created_at`       | `TIMESTAMP`    | `NOT NULL`                         | 作成日時                              |
| `updated_at`       | `TIMESTAMP`    | `DEFAULT CURRENT_TIMESTAMP`        | 更新日時                              |

---

### 3.11. `weights` - 商品重量情報

商品の品質管理のため、重量の実測値を管理します。

| カラム名          | 型             | 制約                               | 備考                                  |
| ----------------- | -------------- | ---------------------------------- | ------------------------------------- |
| `id`              | `BIGINT`       | `PRIMARY KEY`                      | 品質管理記録 ID（主キー）             |
| `spec_code`       | `VARCHAR(10)`  | `FOREIGN KEY (products.spec_code)` | 測定対象商品の製造番号（外部キー）    |
| `actual_weight_1` | `DECIMAL(6,2)` | `NULLABLE`                         | 実測値 1 回目（g）                    |
| `actual_weight_2` | `DECIMAL(6,2)` | `NULLABLE`                         | 実測値 2 回目                         |
| `actual_weight_3` | `DECIMAL(6,2)` | `NULLABLE`                         | 実測値 3 回目                         |
| `actual_weight_4` | `DECIMAL(6,2)` | `NULLABLE`                         | 実測値 4 回目                         |
| `actual_weight_5` | `DECIMAL(6,2)` | `NULLABLE`                         | 実測値 5 回目                         |
| `user_id`         | `BIGINT`       | `FOREIGN KEY (users.id)`           | 測定を記録したユーザー ID（外部キー） |
| `created_at`      | `TIMESTAMP`    | `NOT NULL`                         | 作成日時                              |
| `updated_at`      | `TIMESTAMP`    | `DEFAULT CURRENT_TIMESTAMP`        | 更新日時                              |

---

### 3.12. `sales` - 売上情報

売上を管理します。

| カラム名       | 型              | 制約                               | 備考                                  |
| -------------- | --------------- | ---------------------------------- | ------------------------------------- |
| `id`           | `BIGINT`        | `PRIMARY KEY`                      | 売上記録の ID（主キー）               |
| `spec_code`    | `VARCHAR(10)`   | `FOREIGN KEY (products.spec_code)` | 売上対象商品の製造番号（外部キー）    |
| `sales_amount` | `DECIMAL(10,2)` | `NOT NULL`                         | 売上金額（円）                        |
| `sales_date`   | `DATE`          | `NOT NULL`                         | 売上日                                |
| `user_id`      | `BIGINT`        | `FOREIGN KEY (users.id)`           | 売上を記録したユーザー ID（外部キー） |
| `created_at`   | `TIMESTAMP`     | `NOT NULL`                         | 作成日時                              |
| `updated_at`   | `TIMESTAMP`     | `DEFAULT CURRENT_TIMESTAMP`        | 更新日時                              |

---

### 3.13. `schedules` - 製造予定

製造予定を管理します。

| カラム名         | 型            | 制約                               | 備考                                  |
| ---------------- | ------------- | ---------------------------------- | ------------------------------------- |
| `id`             | `BIGINT`      | `PRIMARY KEY`                      | 製造予定 ID（主キー）                 |
| `spec_code`      | `VARCHAR(10)` | `FOREIGN KEY (products.spec_code)` | 製造予定の商品の製造番号（外部キー）  |
| `scheduled_date` | `DATE`        | `NOT NULL`                         | 製造予定日                            |
| `scheduled_time` | `TIME`        | `NULLABLE`                         | 製造予定時刻                          |
| `quantity_cell`  | `INT`         | `NOT NULL`                         | 製造予定数(cell)                      |
| `user_id`        | `BIGINT`      | `FOREIGN KEY (users.id)`           | 予定を登録したユーザー ID（外部キー） |
| `created_at`     | `TIMESTAMP`   | `NOT NULL`                         | 作成日時                              |
| `updated_at`     | `TIMESTAMP`   | `DEFAULT CURRENT_TIMESTAMP`        | 更新日時                              |
