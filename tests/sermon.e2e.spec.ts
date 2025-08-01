import { test, expect } from '@playwright/test';

test.describe('講道系統整體驗收測試', () => {
  test('前台講道列表與單篇功能', async ({ page }) => {
    // 講道列表
    await page.goto('/sermons');
    await expect(page).toHaveTitle(/講道/);
    await expect(page.locator('h1, .page-title')).toContainText('講道');
    const sermonList = page.locator('.sermon-item, .card, .list-item');
    if (await sermonList.count() > 0) {
      await expect(sermonList.first()).toBeVisible();
      await sermonList.first().click();
      await expect(page.url()).toContain('/sermons/');
      await expect(page.locator('h1, .page-title')).not.toBeEmpty();
      await expect(page.locator('.sermon-player, audio, video, iframe')).toBeVisible();
    }
  });

  test('講道搜尋與篩選', async ({ page }) => {
    await page.goto('/sermons');
    // 搜尋功能
    const searchInput = page.locator('input[type="search"], input[name*="search"]');
    if (await searchInput.count() > 0) {
      await searchInput.first().fill('信心');
      await searchInput.first().press('Enter');
      await expect(page).toHaveURL(/search|sermons/);
    }
    // 篩選功能（講員/日期/標籤）
    const filter = page.locator('select, .filter, .tag');
    if (await filter.count() > 0) {
      await filter.first().selectOption({ index: 1 });
      await expect(page).toHaveURL(/sermons/);
    }
  });

  test('後台講道管理 CRUD', async ({ page }) => {
    await page.goto('/admin/sermons');
    // 新增
    const addBtn = page.getByRole('button', { name: /新增|建立/ });
    if (await addBtn.count() > 0) {
      await addBtn.first().click();
      await expect(page).toHaveURL(/create/);
      await page.fill('input[name="title"]', '自動化測試講道');
      await page.fill('input[name="speaker"]', '測試講員');
      await page.fill('input[name="sermon_date"]', '2025-08-01');
      await page.click('button[type="submit"]');
      await expect(page.locator('.alert-success')).toBeVisible();
    }
    // 編輯
    const editBtn = page.getByRole('button', { name: /編輯/ });
    if (await editBtn.count() > 0) {
      await editBtn.first().click();
      await expect(page).toHaveURL(/edit/);
      await page.fill('input[name="title"]', '自動化測試講道-修改');
      await page.click('button[type="submit"]');
      await expect(page.locator('.alert-success')).toBeVisible();
    }
    // 刪除
    const deleteBtn = page.getByRole('button', { name: /刪除/ });
    if (await deleteBtn.count() > 0) {
      await deleteBtn.first().click();
      await page.click('button, .btn-danger, .swal2-confirm');
      await expect(page.locator('.alert-success')).toBeVisible();
    }
  });

  test('API 取得講道列表', async ({ request }) => {
    const res = await request.get('/api/sermons');
    expect(res.ok()).toBeTruthy();
    const data = await res.json();
    expect(Array.isArray(data.data) || Array.isArray(data)).toBeTruthy();
  });

  test('效能與 SEO 基本檢查', async ({ page }) => {
    await page.goto('/sermons');
    // 效能：載入時間
    const start = Date.now();
    await page.waitForLoadState('networkidle');
    const loadTime = Date.now() - start;
    expect(loadTime).toBeLessThan(6000);
    // SEO：meta tag
    await expect(page.locator('meta[name="description"]')).toBeVisible();
    await expect(page.locator('title')).not.toBeEmpty();
  });
});
