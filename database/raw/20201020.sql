-- article
ALTER TABLE `article` ADD `src_basename` VARCHAR(255) NULL DEFAULT NULL COMMENT 'ブック変換元ファイルのベース名（拡張子を除いたもの）例：読書室.PDF → 読書室' AFTER `wb_book_seq` ;