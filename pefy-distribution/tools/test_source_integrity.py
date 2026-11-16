import tempfile
import unittest
from pathlib import Path
from source_integrity import inventory, REQUIRED

class InventoryTests(unittest.TestCase):
    def test_empty_directory_holds(self):
        with tempfile.TemporaryDirectory() as d:
            result = inventory(Path(d))
            self.assertEqual(result["status"], "HOLD")
            self.assertEqual(set(result["missing_required"]), set(REQUIRED))
            self.assertFalse(result["production_ready"])
    def test_files_without_git_still_hold(self):
        with tempfile.TemporaryDirectory() as d:
            for name in REQUIRED:
                p = Path(d) / name
                p.parent.mkdir(parents=True, exist_ok=True)
                p.write_text("test")
            result = inventory(Path(d))
            self.assertEqual(result["status"], "HOLD")
            self.assertFalse(result["upstream_parity_verified"])

if __name__ == "__main__":
    unittest.main()
