"""Read-only Chamilo source inventory. Does not install or deploy."""
import json
import subprocess
from pathlib import Path

REQUIRED = ("composer.json", "composer.lock", "license.txt", "src/Kernel.php", "public/index.php")
def inventory(root: Path):
    root = root.resolve()
    checks = {name: (root / name).is_file() for name in REQUIRED}
    try:
        result = subprocess.run(["git", "-C", str(root), "ls-files", "-z"], capture_output=True, check=True)
        tracked = [x.decode("utf-8", errors="replace") for x in result.stdout.split(b"\0") if x]
        git_ok = True
    except (OSError, subprocess.CalledProcessError):
        tracked, git_ok = [], False
    return {"checks": checks, "git_inventory_available": git_ok, "tracked_file_count": len(tracked), "missing_required": [k for k, v in checks.items() if not v], "status": "BASELINE_PRESENT_NOT_UPSTREAM_VERIFIED" if all(checks.values()) and git_ok else "HOLD", "upstream_parity_verified": False, "production_ready": False}

if __name__ == "__main__":
    report = inventory(Path(__file__).resolve().parents[2])
    print(json.dumps(report, indent=2))
    raise SystemExit(0 if report["status"] == "BASELINE_PRESENT_NOT_UPSTREAM_VERIFIED" else 2)
