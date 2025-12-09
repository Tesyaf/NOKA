"""
Quick offline demo for the hybrid inference (rule CF + fuzzy scoring).
Run: python tools/fuzzy_hybrid_demo.py
"""

from typing import List, Dict


def combine_cf(cf_old: float, cf_new: float) -> float:
    return cf_old + cf_new * (1 - cf_old)


def infer(pakar_rules: List[Dict], user_gejala: List[int], alpha: float = 0.6):
    """
    pakar_rules: list of dict {id, weight}
    user_gejala: list of gejala ids chosen by user (cf_user = 1)
    """
    cf = 0.0
    score = 0.0
    sum_weight = 0.0
    for rule in pakar_rules:
        sum_weight += rule["weight"]
        if rule["id"] in user_gejala:
            rule_cf = rule["weight"] * 1.0
            cf = combine_cf(cf, rule_cf)
            score += rule_cf

    fuzzy = score / sum_weight if sum_weight else 0.0
    combined = alpha * cf + (1 - alpha) * fuzzy
    return {"cf": cf, "fuzzy": fuzzy, "combined": combined}


if __name__ == "__main__":
    rules = [{"id": 1, "weight": 0.7}, {"id": 2, "weight": 0.5}, {"id": 3, "weight": 0.4}]
    user = [1, 3]
    result = infer(rules, user)
    print("Hybrid result:", result)
